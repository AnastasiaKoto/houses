<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Iblock\ElementTable;

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if (!Bitrix\Main\Loader::includeModule('highloadblock')) {
    throw new Exception('Модуль Highloadblock не установлен');
}

$roomsForJsOffers = [];
$rsEnum = CIBlockPropertyEnum::GetList(
    ["SORT" => "ASC", "ID" => "ASC"],
    ["IBLOCK_ID" => 6, "CODE" => "HOUSES_ROOMS"]
);
while ($enum = $rsEnum->GetNext()) {
    $roomsForJsOffers[$enum['ID']] = $enum['VALUE'];
}

function getHlData($valueId, $tableName) {
    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getList(array(
        'filter' => array('=TABLE_NAME' => $tableName)
    ))->fetch();

    if($hlblock) {
        $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();

        $item = $entityClass::getList(array(
            'select' => array('*'),
            'filter' => array('=UF_XML_ID'=>$valueId)
        ))->fetch();

        if($item) {
            if(!empty($item['UF_FILE'])) {
                $item['UF_FILE'] = CFile::GetPath($item['UF_FILE']);
            }
        }
        return $item;
    }

    return null;
}

//получаем привязанные вариации проекта
if(isset($arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE']) && !empty($arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'])) {
    if(!is_array($arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'])) {
        $arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'] = (array)$arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'];
    }

    $arResult['VARIATIONS'] = [];
    foreach($arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'] as $variation_id) {
        $arSelect = array(
            "ID", 
            "IBLOCK_ID", 
            "NAME",
            "PREVIEW_TEXT"
        );
        $arFilter = array("ID" => $variation_id, "ACTIVE" => "Y");

        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        if($obElement = $res->GetNextElement()) {
            $arElement = $obElement->GetFields();
            $arElement['PROPERTIES'] = $obElement->GetProperties();
            
            $arResult['VARIATIONS'][] = $arElement;
        }
    }

    //получаем дополнительные постройки
    if(!empty($arResult['PROPERTIES']['BUILDINGS']['VALUE'])) {
        $tableName = $arResult['PROPERTIES']['BUILDINGS']['USER_TYPE_SETTINGS']['TABLE_NAME'];

        foreach($arResult['PROPERTIES']['BUILDINGS']['VALUE'] as $building) {
            $item = getHlData($building, $tableName);
            if($item !== null) {
                if(!empty($item['UF_GALLERY'])) {
                    foreach($item['UF_GALLERY'] as $key => $img) {
                        $item['UF_GALLERY'][$key] = CFile::GetPath($img);
                    }
                }
                if(!empty($item['UF_PLANE'])) {
                    $item['UF_PLANE'] = CFile::GetPath($item['UF_PLANE']);
                }
                $arResult['PROPERTIES']['BUILDINGS']['VALUE_ITEMS'][$building] = $item;
            }
        }
    }
} else {
    if(!empty($arResult['PROPERTIES']['GALLERY']['VALUE'])) {
        foreach($arResult['PROPERTIES']['GALLERY']['VALUE'] as $key => $image) {
            $arImage = [];
            $arImage['DESCRIPTION'] = $arResult['PROPERTIES']['GALLERY']['DESCRIPTION'][$key];
            $arImage['PATH'] = CFile::GetPath($image);

            $arResult['PROPERTIES']['GALLERY']['VALUE'][$key] = $arImage;
        }
    }
}

foreach($arResult['PROPERTIES'] as $key => $value) {
    if($value['USER_TYPE'] == 'directory') {
        $tableName = $value['USER_TYPE_SETTINGS']['TABLE_NAME'];
        if($value['MULTIPLE'] == 'Y' && !empty($value['VALUE'])) {
            foreach($value['VALUE'] as $el) {
                $valueId = $el;
                $item = getHlData($valueId, $tableName);
                $value['VALUE_ELEMENT'][] = $item;
            }
        } else {
            $valueId = $value['VALUE'];
            if($valueId && $tableName) {
                $item = getHlData($valueId, $tableName);
                $value['VALUE_ELEMENT'] = $item;
            }
        }
    }
}

//p($arResult['PROPERTIES']['BUILDINGS']);

//формируем и уникализируем массив из свойств для вывода
if(isset($arResult['VARIATIONS']) && !empty($arResult['VARIATIONS'])) {
    $props = [];
    $uniqueValues = [];
    foreach($arResult['VARIATIONS'] as $variation) {
        if(!empty($variation['PROPERTIES'])) {
            foreach($variation['PROPERTIES'] as $key => $prop) {
                if (strpos($key, 'HOUSES_') !== false) {
                    if (!isset($props[$key])) {
                        $props[$key] = [];
                    }
                    if (!isset($uniqueValues[$key])) {
                        $uniqueValues[$key] = [];
                    }
                    
                    if (!in_array($prop['VALUE'], $uniqueValues[$key])) {
                        if($prop['USER_TYPE'] == 'directory') {
                            $valueId = $prop['VALUE'];
                            $tableName = $prop['USER_TYPE_SETTINGS']['TABLE_NAME'];
                            if($valueId && $tableName) {
                                $item = getHlData($valueId, $tableName);
                                $prop['VALUE_ELEMENT'] = $item;
                            }
                        }
                        $uniqueValues[$key][] = $prop['VALUE'];
                        $props[$key][] = $prop;
                    }
                }
            }
        }
    }
}

$arResult['PROPS'] = $props;

//формируем массив с комбинациями
if(!empty($arResult['PROPS']) && !empty($arResult['VARIATIONS'])) {
    $arResult['JS_OFFERS'] = [];
    
    foreach($arResult['VARIATIONS'] as $variation) {
        $offer = [
            'ID' => $variation['ID'],
            'NAME' => $variation['NAME'],
            'PREVIEW_TEXT' => $variation['PREVIEW_TEXT'],
            'PROPERTIES' => [],
            'COMBINATION' => []
        ];

        foreach($variation['PROPERTIES'] as $key => $value) {
            if ($value['USER_TYPE'] == 'HTML' && isset($value['VALUE']['TEXT'])) {
                $value['VALUE'] = $value['VALUE']['TEXT'];
            }
            if($key === 'GALLERY' || strpos($key, '_IMAGES') !== false || strpos($key, '_IMG') !== false) {
                if(is_array($value['VALUE'])) {
                    $images_data = [];
                    foreach($value['VALUE'] as $index => $img_id) {
                        $file_path = CFile::GetPath($img_id);
                        $description = $value['DESCRIPTION'][$index] ?? '';
                        
                        $images_data[] = [
                            'PATH' => $file_path,
                            'DESCRIPTION' => $description
                        ];
                    }
                    $value['VALUE'] = $images_data;
                } else {
                    $value['VALUE'] = CFile::GetPath($value['VALUE']);
                }
            }

            if ($key === 'PROJECTS' && !empty($value['VALUE'])) {
                $projectIds = is_array($value['VALUE']) ? $value['VALUE'] : [$value['VALUE']];
                $projectIds = array_unique($projectIds);

                $value['VALUE_ELEMENTS'] = [];

                //foreach ($projectIds as $projectId) {
                    $arSelect = ["ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_PAGE_URL"];
                    $arFilter = ["ID" => $projectIds, "ACTIVE" => "Y"];

                    $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
                    while($element = $res->fetch()) {
                        if (!empty($element['DETAIL_PAGE_URL'])) {
                            $element['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl(
                                $element['DETAIL_PAGE_URL'],
                                $element,
                                false,
                                "E"
                            );
                        }

                        $propsToLoad = ['HOUSES_SQUARES', 'HOUSES_SIZES', 'HOUSES_ROOMS', 'GALLERY'];
                        foreach ($propsToLoad as $propCode) {
                            $propRes = CIBlockElement::GetProperty(
                                $element["IBLOCK_ID"],
                                $element["ID"],
                                ["sort" => "asc"],
                                ["CODE" => $propCode]
                            );
                            $propValues = [];
                            while ($prop = $propRes->fetch()) {
                                if($prop['CODE'] == 'HOUSES_ROOMS') {
                                    $prop['VALUE'] = $roomsForJsOffers[$prop['VALUE']];
                                }
                                if($prop['CODE'] == 'GALLERY') {
                                    $prop['VALUE'] = CFile::GetPath($prop['VALUE']);
                                }
                                if(!empty($prop['VALUE'])) {
                                    $propValues[] = $prop['VALUE'];
                                }
                            }
                            $element["PROPERTY_{$propCode}_VALUE"] = $propValues ?? null;
                        }

                        $value['VALUE_ELEMENTS'][] = $element;
                    }
                //}
            }

            if($value['USER_TYPE'] == 'directory') {
                $tableName = $value['USER_TYPE_SETTINGS']['TABLE_NAME'];
                if($value['MULTIPLE'] == 'Y' && !empty($value['VALUE'])) {
                    foreach($value['VALUE'] as $el) {
                        $valueId = $el;
                        $item = getHlData($valueId, $tableName);
                        $value['VALUE_ELEMENT'][] = $item;
                    }
                } else {
                    $valueId = $value['VALUE'];
                    if($valueId && $tableName) {
                        $item = getHlData($valueId, $tableName);
                        $value['VALUE_ELEMENT'] = $item;
                    }
                }
            }
            $offer['PROPERTIES'][$key] = $value;
            if(strpos($key, 'HOUSES_') !== false) {
                $value_id = $value['VALUE_ENUM_ID'] ? $value['VALUE_ENUM_ID'] : $value['VALUE'];
                $offer['COMBINATION'][] = $key . ':' . $value_id; 
            }
        }
        /*
        if(!empty($variation['PROPERTIES']['PROJECT']['VALUE'])) {
            $arSelect = array(
                "ID", 
                "IBLOCK_ID", 
                "NAME",
                "PREVIEW_TEXT",
                "DETAIL_PAGE_URL",
                "PROPERTY_HOUSES_SQUARES",
                "PROPERTY_HOUSES_SIZES",
                "PROPERTY_HOUSES_ROOMS"
            );
            $arFilter = array("ID" => $variation['PROPERTIES']['PROJECT']['VALUE'], "ACTIVE" => "Y");

            $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
            $value['VALUE_ELEMENTS'] = [];
            while($element = $res->fetch()) {
                if(!empty($element['DETAIL_PAGE_URL'])) {
                    $element['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl(
                        $element['DETAIL_PAGE_URL'], 
                        $element, 
                        false, 
                        "E"
                    );
                }
                $offer['PROPERTIES']['PROJECT']['VALUE_ELEMENTS'][] = $element;
            }
        }
        */

        sort($offer['COMBINATION']);
        $combinationKey = implode('|', $offer['COMBINATION']);
        $offer['COMBINATION_KEY'] = $combinationKey;
        $arResult['JS_OFFERS'][$combinationKey] = $offer;
    }
}

//p($arResult);