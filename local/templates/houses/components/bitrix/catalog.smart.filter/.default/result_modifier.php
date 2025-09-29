<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//сортировка
$arSortParams = [
    'default' => ['NAME' => 'Порядок: по умолчанию', 'SORT' => 'SORT', 'ORDER' => 'ASC'], // Стандартное поле SORT
    'price_asc' => ['NAME' => 'Цена: по возрастанию', 'SORT' => 'PROPERTY_HOUSES_PRICES', 'ORDER' => 'ASC'],
    'price_desc' => ['NAME' => 'Цена: по убыванию', 'SORT' => 'PROPERTY_HOUSES_PRICES', 'ORDER' => 'DESC'],
    'name_asc' => ['NAME' => 'Название: от А-Я', 'SORT' => 'NAME', 'ORDER' => 'ASC'],
    'name_desc' => ['NAME' => 'Название: от Я-А', 'SORT' => 'NAME', 'ORDER' => 'DESC'],
    'date_desc' => ['NAME' => 'Порядок: сперва новые', 'SORT' => 'ACTIVE_FROM', 'ORDER' => 'DESC'],
    'date_asc' => ['NAME' => 'Порядок: сперва старые', 'SORT' => 'ACTIVE_FROM', 'ORDER' => 'ASC']
];

$currentSort = $_REQUEST['sort'] ?? 'default';
$activeSort = $arSortParams[$currentSort] ?? $arSortParams['default'];

$arResult['HIDDEN'] = array_filter($arResult['HIDDEN'] ?? [], function($field) {
    return !in_array($field['CONTROL_NAME'], ['sort', 'sort_field', 'sort_order']);
});

$arResult['HIDDEN'][] = [
    'CONTROL_ID' => 'sort_field',
    'CONTROL_NAME' => 'sort_field',
    'HTML_VALUE' => $activeSort['SORT']
];

$arResult['HIDDEN'][] = [
    'CONTROL_ID' => 'sort_order',
    'CONTROL_NAME' => 'sort_order',
    'HTML_VALUE' => $activeSort['ORDER']
];

$arResult['HIDDEN'][] = [
    'CONTROL_ID' => 'sort',
    'CONTROL_NAME' => 'sort',
    'HTML_VALUE' => $currentSort
];

$arResult['ITEMS']['SORT'] = [];
foreach ($arSortParams as $key => $params) {
    $arResult['ITEMS']['SORT'][$key] = [
        'NAME' => $params['NAME'],
        'ACTIVE' => $currentSort === $key,
        'SORT' => $params['SORT'],
        'ORDER' => $params['ORDER']
    ];
}

// Добавляем скрытые поля для всех параметров фильтра
if (!empty($_REQUEST['set_filter']) && $_REQUEST['set_filter'] == 'y') {
    foreach ($_REQUEST as $key => $value) {
        if (strpos($key, 'arrFilter_') === 0) {
            $arResult['HIDDEN'][] = [
                'CONTROL_ID' => $key,
                'CONTROL_NAME' => $key,
                'HTML_VALUE' => $value
            ];
        }
    }
}

// Порядок вывода
$desiredOrder = ['SORT', '25', 'BASE', '64'];
$orderedItems = [];
foreach ($desiredOrder as $key) {
    if (isset($arResult['ITEMS'][$key])) {
        $orderedItems[$key] = $arResult['ITEMS'][$key];
        unset($arResult['ITEMS'][$key]);
    }
}
$arResult['ITEMS'] = array_merge($orderedItems, $arResult['ITEMS']);
