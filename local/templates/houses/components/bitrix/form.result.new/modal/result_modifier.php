<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Loader; 
Loader::includeModule('highloadblock'); 

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
    if (!empty($arQuestion["STRUCTURE"][0]["FIELD_TYPE"]) && $arQuestion["STRUCTURE"][0]["FIELD_TYPE"] === "checkbox") {
        $html = $arQuestion['HTML_CODE'];
        if (preg_match('/<input\b[^>]*>/i', $html, $matches)) {
            $arResult["QUESTIONS"][$FIELD_SID]['HTML_CODE'] = $matches[0];
        }
    }
}

$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList([
    'filter' => ['=NAME' => 'Socials'] 
])->fetch();

if ($hlblock) {
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();

    $items = $entityClass::getList([
        'select' => ['ID', 'UF_*']
    ]);

    while ($item = $items->fetch()) {
        $arResult['SOCIALS'][] = $item;
    }
}