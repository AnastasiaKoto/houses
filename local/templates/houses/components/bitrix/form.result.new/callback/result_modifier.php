<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$formPrefix = $arParams['UNIQUE_PREFIX'] ?? 'form_';
if (isset($arResult['FORM_HEADER'])) {
    if (preg_match('/<form[^>]*id="[^"]*"[^>]*>/', $arResult['FORM_HEADER'])) {
        $arResult['FORM_HEADER'] = preg_replace(
            '/(<form[^>]*)id="[^"]*"([^>]*>)/', 
            '$1id="' . $formPrefix . '"$2', 
            $arResult['FORM_HEADER']
        );
    } else {
        $arResult['FORM_HEADER'] = preg_replace(
            '/(<form[^>]*)>/', 
            '$1 id="' . $formPrefix . '">', 
            $arResult['FORM_HEADER']
        );
    }
}
foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
    if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "checkbox") { 
        $arResult["QUESTIONS"][$FIELD_SID]['HTML_CODE'] = preg_replace('#<label\b[^>]*>.*?</label>#is', '', $arResult["QUESTIONS"][$FIELD_SID]['HTML_CODE']);
    }
}