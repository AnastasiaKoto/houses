<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Loader; 
Loader::includeModule('highloadblock'); 

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