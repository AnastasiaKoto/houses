<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if(!empty($arResult['ITEMS'])) {
    foreach($arResult['ITEMS'] as &$arItem) {
        if ($arItem['IBLOCK_SECTION_ID']) {
            $dbSection = CIBlockSection::GetList(
                array(),
                array(
                    'ID' => $arItem['IBLOCK_SECTION_ID'],
                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                    'ACTIVE' => 'Y'
                ),
                false,
                array('ID', 'NAME')
            );
            
            if ($arSection = $dbSection->Fetch()) {
                $arItem['SECTION_NAME'] = $arSection['NAME'];
            }
        }
    } unset($arItem);
} 
?>