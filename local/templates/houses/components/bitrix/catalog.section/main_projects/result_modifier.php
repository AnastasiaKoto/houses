<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

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
        ['SORT' => 'ASC', 'NAME' => 'ASC'],
        [
            'ID' => $sectionIds,
            'SECTION_ID' => 8,
            'ACTIVE' => 'Y'
        ],
        false,
        ['ID', 'NAME']
    );
    
    $validSectionIds = [];
    while ($section = $rsSections->GetNext()) {
        $validSectionIds[$section['ID']] = $section['NAME'];
    }
    
    $groupedItems = [];
    foreach ($arResult['ITEMS'] as $item) {
        $sectionId = $item['IBLOCK_SECTION_ID'];
        
        if (isset($validSectionIds[$sectionId])) {
            $sectionName = $validSectionIds[$sectionId];
            if (!isset($groupedItems[$sectionName])) {
                $groupedItems[$sectionName] = [];
            }
            
            $groupedItems[$sectionName][] = $item;
        }
    }
    
    // Сохраняем результат
    $arResult['MODIFIED_ITEMS'] = $groupedItems;
}