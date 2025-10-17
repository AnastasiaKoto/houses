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

function recreateTextField($code, $arQuestion, $type, $value = false) {
    $field = reset($arQuestion['STRUCTURE']);
    $name = 'form_' . $field['FIELD_TYPE'] . '_' . $field['ID'];
    
    $attrs = [
        'type' => $type,
        'id' => htmlspecialcharsbx($code),
        'name' => htmlspecialcharsbx($name),
        'value' => htmlspecialcharsbx($value ?? $arQuestion['VALUE']),
    ];

    $fieldParam = $arQuestion['STRUCTURE'][0]['FIELD_PARAM'] ?? '';
    
    $attrStr = '';
    foreach ($attrs as $key => $val) {
        $attrStr .= ' ' . $key . '="' . $val . '"';
    }
    
    if (!empty($fieldParam)) {
        $attrStr .= ' ' . $fieldParam;
    }
    
    $inputHtml = '<input' . $attrStr . '>';

    $labelHtml = '<label for="' . htmlspecialcharsbx($code) . '">' . htmlspecialcharsbx($arQuestion['CAPTION']) . '</label>';

    $html_code = $inputHtml . "\n" . $labelHtml;
    return $html_code;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/config/iblocks.php';