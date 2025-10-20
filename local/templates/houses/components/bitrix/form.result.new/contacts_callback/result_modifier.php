<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
    if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "checkbox") { 
        $arResult["QUESTIONS"][$FIELD_SID]['HTML_CODE'] = preg_replace('#<label\b[^>]*>.*?</label>#is', '', $arResult["QUESTIONS"][$FIELD_SID]['HTML_CODE']);
    }
}