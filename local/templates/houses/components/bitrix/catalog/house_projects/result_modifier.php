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
        $arResult['SECTION']['NAME'] = $arSection['NAME'];
        $arResult['SECTION']['ID'] = $arSection['ID'];
        $arResult['SECTION']['PARENT_SECTION_ID'] = $arSection['IBLOCK_SECTION_ID'];

        // Получаем дочерние секции
        $childSectionIds = array();
        $dbChildSections = CIBlockSection::GetList(
            array('SORT' => 'ASC'),
            array(
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'SECTION_ID' => $arSection['ID'],
                'ACTIVE' => 'Y'
            ),
            false,
            array('ID')
        );
        
        while ($childSection = $dbChildSections->Fetch()) {
            $childSectionIds[] = $childSection['ID'];
        }
        $arResult['CHILD_SECTION_IDS'] = $childSectionIds;
    }
}

$arSortParams = [
    'price_asc' => ['NAME' => 'Цена: по возрастанию', 'SORT' => 'PROPERTY_HOUSES_PRICES', 'ORDER' => 'ASC'],
    'price_desc' => ['NAME' => 'Цена: по убыванию', 'SORT' => 'PROPERTY_HOUSES_PRICES', 'ORDER' => 'DESC'],
    'square_asc' => ['NAME' => 'Площадь по возрастанию', 'SORT' => 'PROPERTY_HOUSES_SQUARES', 'ORDER' => 'ASC'],
    'square_desc' => ['NAME' => 'Площадь по убыванию', 'SORT' => 'PROPERTY_HOUSES_SQUARES', 'ORDER' => 'DESC'],
    //'popular_asc' => ['NAME' => 'Популярность по возрастанию', 'SORT' => 'SORT', 'ORDER' => 'ASC'],
    'popular_desc' => ['NAME' => 'По популярности', 'SORT' => 'SORT', 'ORDER' => 'DESC'],
    'date_desc' => ['NAME' => 'Порядок: сперва новые', 'SORT' => 'ACTIVE_FROM', 'ORDER' => 'DESC'],
    'date_asc' => ['NAME' => 'Порядок: сперва старые', 'SORT' => 'ACTIVE_FROM', 'ORDER' => 'ASC']
];

//добавляем сортировку для вывода
$currentSort = $_REQUEST['sort'] ?? 'price_asc';
$activeSort = $arSortParams[$currentSort] ?? $arSortParams['price_asc'];

$arResult['SORT'] = [];
foreach ($arSortParams as $key => $params) {
    $arResult['SORT'][$key] = [
        'NAME' => $params['NAME'],
        'ACTIVE' => $currentSort === $key,
        'SORT' => $params['SORT'],
        'ORDER' => $params['ORDER']
    ];
}
?>