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
        array('ID', 'NAME')
    );
    
    if ($arSection = $dbSection->Fetch()) {
        $arResult['SECTION']['NAME'] = $arSection['NAME'];
        $arResult['SECTION']['ID'] = $arSection['ID'];
    }
}
?>