<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

function p($data = [])
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function logMessage($message) {
    file_put_contents(
        $_SERVER['DOCUMENT_ROOT'].'/debug.log',
        date('Y-m-d H:i:s').$message."\n",
        FILE_APPEND
    );
}

function formatPriceInMillions($price) {
    if($price < 1000000) {
        return number_format($price, 0, ".", " ");
    }
    $millions = $price / 1000000;
    
    // Если число целое - показываем без десятичных
    if ($millions == (int)$millions) {
        return (int)$millions . ' млн';
    }
    
    // Округляем до целых миллионов
    return round($millions) . ' млн';
}

function recreateTextField($code, $arQuestion, $type, $prefix = '', $value = false) {
    $field = reset($arQuestion['STRUCTURE']);
    $name = 'form_' . $field['FIELD_TYPE'] . '_' . $field['ID'];
    
    if($type !== 'checkbox') {
        if($code == 'PHONE') {
            $type = 'tel';
        }
        $attrs = [
            'type' => $type,
            'id' => htmlspecialcharsbx($code) . $prefix,
            'name' => htmlspecialcharsbx($name),
            'value' => htmlspecialcharsbx($value ?? $arQuestion['VALUE']),
        ];
    } else {
        $attrs = [
            'type' => $type,
            'id' => htmlspecialcharsbx($code) . $prefix,
            'name' => 'form_checkbox_' . htmlspecialcharsbx($code) . '[]',
            'value' => htmlspecialcharsbx($field['ID']),
        ];
    }

    $fieldParam = $arQuestion['STRUCTURE'][0]['FIELD_PARAM'] ?? '';
    
    $attrStr = '';
    foreach ($attrs as $key => $val) {
        $attrStr .= ' ' . $key . '="' . $val . '"';
    }
    
    if (!empty($fieldParam)) {
        $attrStr .= ' ' . $fieldParam;
    }
    
    $inputHtml = '<input' . $attrStr . '>';

    if($type !== 'checkbox') {
        $labelHtml = '<label for="' . htmlspecialcharsbx($code) . $prefix . '">' . htmlspecialcharsbx($arQuestion['CAPTION']) . '</label>';
    } else {
        $labelHtml = '';
    }
    

    $html_code = $inputHtml . "\n" . $labelHtml;
    return $html_code;
}

function getUserPhone($resultId, $fieldId) {
    if(CModule::IncludeModule("form")) {
        CFormResult::GetDataByID(
            $resultId,
            array('PHONE'),
            $arResultData,
            $arResult2
        );
        
        $userPhone = $arResult2['PHONE'][$fieldId]['USER_TEXT'] ?? '';
        return $userPhone;
    }
    return false;
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

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/config/iblocks.php';