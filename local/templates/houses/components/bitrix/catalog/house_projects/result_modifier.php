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

//добавляем сортировку для вывода
$currentSort = $_REQUEST['sort'] ?? 'default';
$activeSort = $arSortParams[$currentSort] ?? $arSortParams['default'];

$arSortParams = [
    'default' => ['NAME' => 'Порядок: по умолчанию', 'SORT' => 'SORT', 'ORDER' => 'ASC'], // Стандартное поле SORT
    'price_asc' => ['NAME' => 'Цена: по возрастанию', 'SORT' => 'PROPERTY_HOUSES_PRICES', 'ORDER' => 'ASC'],
    'price_desc' => ['NAME' => 'Цена: по убыванию', 'SORT' => 'PROPERTY_HOUSES_PRICES', 'ORDER' => 'DESC'],
    'name_asc' => ['NAME' => 'Название: от А-Я', 'SORT' => 'NAME', 'ORDER' => 'ASC'],
    'name_desc' => ['NAME' => 'Название: от Я-А', 'SORT' => 'NAME', 'ORDER' => 'DESC'],
    'date_desc' => ['NAME' => 'Порядок: сперва новые', 'SORT' => 'ACTIVE_FROM', 'ORDER' => 'DESC'],
    'date_asc' => ['NAME' => 'Порядок: сперва старые', 'SORT' => 'ACTIVE_FROM', 'ORDER' => 'ASC']
];

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