<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$_SERVER["DOCUMENT_ROOT"] = 'www/10domov.ru/';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Loader::includeModule('iblock');
Loader::includeModule('catalog');
Loader::includeModule('highloadblock');

function logMessage($message) {
    $logFile = $_SERVER["DOCUMENT_ROOT"] . '/import/variations.log';
    $timestamp = date("Y-m-d H:i:s");
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

function getPropertyEnumId($propertyCode, $value, $iblockId) {
    if (empty($value)) return null;
    
    $property = CIBlockProperty::GetList([], [
        'CODE' => $propertyCode,
        'IBLOCK_ID' => $iblockId
    ])->Fetch();
    
    if (!$property) {
        logMessage("Свойство $propertyCode не найдено");
        return null;
    }

    $enumRes = CIBlockPropertyEnum::GetList([], [
        'PROPERTY_ID' => $property['ID'],
        'VALUE' => $value
    ]);
    
    if ($existing = $enumRes->Fetch()) {
        return $existing['ID'];
    }
    
    $newEnum = new CIBlockPropertyEnum;
    $newId = $newEnum->Add([
        'PROPERTY_ID' => $property['ID'],
        'VALUE' => $value
    ]);
    
    return $newId ?: null;
}

function generateCode($name, $iblockId = 0) {
    $params = array(
        "max_len" => 100,
        "change_case" => 'L',
        "replace_space" => '-',
        "replace_other" => '-',
        "delete_repeat_replace" => true,
        "use_google" => false,
    );
    
    $baseCode = CUtil::translit($name, "ru", $params);
    $code = $baseCode;
    $counter = 1;
    
    if ($iblockId > 0) {
        $filter = [
            'IBLOCK_ID' => $iblockId,
            '=CODE' => $code
        ];
        
        $res = CIBlockElement::GetList([], $filter, false, false, ['ID']);
        while ($res->Fetch()) {
            $code = $baseCode . '-' . $counter;
            $filter['=CODE'] = $code;
            $res = CIBlockElement::GetList([], $filter, false, false, ['ID']);
            $counter++;
        }
    }
    
    return $code;
}

function importOffersSimple($csvFilePath) {
    $iblockId = 6;
    $offersIblockId = 11;
    
    $handle = fopen($csvFilePath, 'r');
    if (!$handle) {
        throw new Exception("Не удалось открыть файл: $csvFilePath");
    }

    $header = fgetcsv($handle, 10000, ',');
    if (!$header) {
        throw new Exception("Ошибка чтения заголовков CSV");
    }
    
    while (($data = fgetcsv($handle, 10000, ',')) !== false) {
        $row = array_combine($header, $data);
        
        if ($row['Тип товара'] !== 'предложение') continue;
        
        $parentProductId = (int)$row['Элемент каталога'];
        if (!$parentProductId) {
            logMessage("Пропуск: не указан ID товара для предложения '{$row['Название']}'");
            continue;
        }

        // Проверяем существование родительского товара
        $res = CIBlockElement::GetList(
            [],
            ['ID' => $parentProductId, 'IBLOCK_ID' => $iblockId],
            false,
            false,
            ['ID', 'NAME']
        );
        
        if (!$arParent = $res->Fetch()) {
            logMessage("Родительский товар $parentProductId не существует, пропускаем предложение");
            continue;
        }

        $sizeId = !empty($row['Размер']) ? getPropertyEnumId('SIZE', $row['Размер'], $offersIblockId) : null;
        $volumeId = !empty($row['Объем']) ? getPropertyEnumId('VOLUME', $row['Объем'], $offersIblockId) : null;
        $productCode = generateCode($row['Название'], $offersIblockId);
        
        $el = new CIBlockElement;
        
        $offerFields = [
            'IBLOCK_ID' => $offersIblockId,
            'NAME' => $row['Название'],
            'CODE' => $productCode,
            'ACTIVE' => $row['Активность'] == 'Да' ? 'Y' : 'N',
            'PROPERTY_VALUES' => [
                'CML2_LINK' => $parentProductId, // Привязка к товару по ID
                'COLOR_REF' => $row['Цвет'],
                'SIZE' => $sizeId,
                'VOLUME' => $volumeId
            ]
        ];

        $offerId = $el->Add($offerFields);
        
        if ($offerId) {
            logMessage("Создано предложение ID: $offerId для товара $parentProductId ({$arParent['NAME']})");
            
            // Добавляем в каталог
            $catalogFields = [
                'ID' => $offerId,
                'QUANTITY' => (int)$row['Доступное количество'] ?? 0,
                'VAT_ID' => 2,
                'VAT_INCLUDED' => 'Y',
                'TYPE' => CCatalogProduct::TYPE_OFFER
            ];
            
            if (!CCatalogProduct::Add($catalogFields)) {
                logMessage("Ошибка добавления в каталог для предложения $offerId: " . $GLOBALS['APPLICATION']->GetException());
            }
            
            if (!CPrice::Add([
                'PRODUCT_ID' => $offerId,
                'CATALOG_GROUP_ID' => 1,
                'PRICE' => (int)$row['Розничная цена'],
                'CURRENCY' => 'RUB'
            ])) {
                logMessage("Ошибка добавления цены для предложения $offerId: " . $GLOBALS['APPLICATION']->GetException());
            }
        } else {
            logMessage("Ошибка создания предложения: " . $el->LAST_ERROR);
        }
    }
    
    fclose($handle);
}

try {
    importOffersSimple($_SERVER["DOCUMENT_ROOT"] . '/import/variations.csv');
} catch (Exception $e) {
    logMessage("Ошибка: " . $e->getMessage());
}