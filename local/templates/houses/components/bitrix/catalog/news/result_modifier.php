<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$sectionCode = $arResult['VARIABLES']['SECTION_CODE'];
if ($sectionCode) {
    // Получаем раздел по символьному коду
    $dbSection = CIBlockSection::GetList(
        array(),
        array(
            'CODE' => $sectionCode,
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ACTIVE' => 'Y'
        ),
        false,
        array('ID', 'NAME', 'IBLOCK_SECTION_ID')
    );
    
    if ($arSection = $dbSection->Fetch()) {
        $arResult['SECTION']['CURID'] = $arSection['ID'];
    }
}
?>