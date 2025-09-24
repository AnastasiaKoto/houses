<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('highloadblock');
$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$sectionIds = [];
foreach ($arResult['ITEMS'] as $item) {
    if (!empty($item['IBLOCK_SECTION_ID'])) {
        $sectionIds[] = $item['IBLOCK_SECTION_ID'];
    }
}

if (!empty($sectionIds)) {
    $sectionIds = array_unique($sectionIds);
    
    $rsSections = CIBlockSection::GetList(
        ['SORT' => 'ASC'],
        [
            'ID' => $sectionIds,
            'SECTION_ID' => 8,
            'ACTIVE' => 'Y'
        ],
        false,
        ['ID', 'NAME', 'SORT']
    );
    
    $sectionsOrder = [];
    $validSections = [];
    
    while ($section = $rsSections->GetNext()) {
        $sectionsOrder[] = $section['ID'];
        $validSections[$section['ID']] = $section['NAME'];
    }
    
    $groupedItems = [];

    foreach ($sectionsOrder as $sectionId) {
        $sectionName = $validSections[$sectionId];
        $groupedItems[$sectionName] = [];
        
        foreach ($arResult['ITEMS'] as $item) {
            if ($item['IBLOCK_SECTION_ID'] == $sectionId) {
                $groupedItems[$sectionName][] = $item;
            }
        }

        if (empty($groupedItems[$sectionName])) {
            unset($groupedItems[$sectionName]);
        }
    }
    
    $arResult['MODIFIED_ITEMS'] = $groupedItems;
}


//получаем характеристики справочника
if(!empty($arResult['MODIFIED_ITEMS'])) {
    foreach($arResult['MODIFIED_ITEMS'] as &$arSection) {
        if(!empty($arSection)) {
            foreach($arSection as &$arItem) {
                $property = $arItem['PROPERTIES']['CARD_CH'];
                $tableName = $property['USER_TYPE_SETTINGS']['TABLE_NAME'];
                $xmlIds = $property['VALUE'];
                
                if (!empty($xmlIds)) {
                    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getList([
                        'filter' => ['TABLE_NAME' => $tableName]
                    ])->fetch();
                    if ($hlblock) {
                        $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
                        $entityDataClass = $entity->getDataClass();
                        
                        // Получаем все значения за один запрос
                        $rsData = $entityDataClass::getList([
                            'filter' => ['UF_XML_ID' => $xmlIds]
                        ]);
                        
                        $allValues = [];
                        while ($item = $rsData->fetch()) {
                            $allValues[$item['UF_XML_ID']] = $item;
                        }
                        $arItem['CARD_CHARACTERISTICS'] = $allValues;
                    }
                }
            }
            unset($arItem);
        }
    }
    unset($arSection);
}
?>