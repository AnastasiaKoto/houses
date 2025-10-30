<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Iblock\ElementTable;

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if (!Bitrix\Main\Loader::includeModule('highloadblock')) {
    throw new Exception('Модуль Highloadblock не установлен');
}

$roomsForJsOffers = [];
$rsEnum = CIBlockPropertyEnum::GetList(
    ["SORT" => "ASC", "ID" => "ASC"],
    ["IBLOCK_ID" => 6, "CODE" => "HOUSES_ROOMS"]
);
while ($enum = $rsEnum->GetNext()) {
    $roomsForJsOffers[$enum['ID']] = $enum['VALUE'];
}

function getProjects($projectIds, $roomsForJsOffers = false) {

    $arSelect = ["ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_PAGE_URL"];
    $arFilter = ["ID" => $projectIds, "ACTIVE" => "Y"];

    $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
    $elements = [];
    while($element = $res->fetch()) {
        if (!empty($element['DETAIL_PAGE_URL'])) {
            $element['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl(
                $element['DETAIL_PAGE_URL'],
                $element,
                false,
                "E"
            );
        }

        $propsToLoad = ['HOUSES_SQUARES', 'HOUSES_SIZES', 'HOUSES_ROOMS', 'GALLERY'];
        foreach ($propsToLoad as $propCode) {
            $propRes = CIBlockElement::GetProperty(
                $element["IBLOCK_ID"],
                $element["ID"],
                ["sort" => "asc"],
                ["CODE" => $propCode]
            );
            $propValues = [];
            while ($prop = $propRes->fetch()) {
                if($prop['CODE'] == 'HOUSES_ROOMS') {
                    $prop['VALUE'] = $roomsForJsOffers[$prop['VALUE']];
                }
                if($prop['CODE'] == 'GALLERY') {
                    $prop['VALUE'] = CFile::GetPath($prop['VALUE']);
                }
                if(!empty($prop['VALUE'])) {
                    $propValues[] = $prop['VALUE'];
                }
            }
            $element["PROPERTY_{$propCode}_VALUE"] = $propValues ?? null;
        }

        $elements[] = $element;
    }

    return $elements;
}

//получаем привязанные вариации проекта
if(isset($arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE']) && !empty($arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'])) {
    if(!is_array($arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'])) {
        $arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'] = (array)$arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'];
    }

    $arResult['VARIATIONS'] = [];
    foreach($arResult['PROPERTIES']['HOUSE_VARIABLES']['VALUE'] as $variation_id) {
        $arSelect = array(
            "ID", 
            "IBLOCK_ID", 
            "NAME",
            "PREVIEW_TEXT",
            "ACTIVE"
        );
        $arFilter = array("ID" => $variation_id);

        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        if($obElement = $res->GetNextElement()) {
            $arElement = $obElement->GetFields();
            $arElement['PROPERTIES'] = $obElement->GetProperties();
            
            $arResult['VARIATIONS'][] = $arElement;
        }
    }

} else {
    if(!empty($arResult['PROPERTIES']['GALLERY']['VALUE'])) {
        foreach($arResult['PROPERTIES']['GALLERY']['VALUE'] as $key => $image) {
            $arImage = [];
            $arImage['DESCRIPTION'] = $arResult['PROPERTIES']['GALLERY']['DESCRIPTION'][$key];
            $arImage['PATH'] = CFile::GetPath($image);

            $arResult['PROPERTIES']['GALLERY']['VALUE'][$key] = $arImage;
        }
    }

    //получаем данные hl блоков
    foreach($arResult['PROPERTIES'] as $key => &$value) {
        if($value['USER_TYPE'] == 'directory') {
            $tableName = $value['USER_TYPE_SETTINGS']['TABLE_NAME'];
            if ($value['MULTIPLE'] == 'Y' && !empty($value['VALUE'])) {
                $value['VALUE_ELEMENT'] = [];
                foreach($value['VALUE'] as $el) {
                    $valueId = $el;
                    $item = getHlData($valueId, $tableName);
                    if ($item) {
                        if (isset($item['UF_PLANE']) && !empty($item['UF_PLANE'])) {
                            $item['UF_PLANE'] = CFile::GetPath($item['UF_PLANE']);
                        }
                        if (!empty($item['UF_GALLERY']) && is_array($item['UF_GALLERY'])) {
                            foreach ($item['UF_GALLERY'] as $idx => $fileId) {
                                $item['UF_GALLERY'][$idx] = CFile::GetPath($fileId);
                            }
                        }
                        $value['VALUE_ELEMENT'][] = $item;
                    }
                }
            } else {
                $valueId = $value['VALUE'];
                if ($valueId && $tableName) {
                    $item = getHlData($valueId, $tableName);
                    if ($item) {
                        if (isset($item['UF_FILE']) && !empty($item['UF_FILE'])) {
                            $item['UF_FILE'] = CFile::GetPath($item['UF_FILE']);
                        }
                        if (isset($item['UF_PLANE']) && !empty($item['UF_PLANE'])) {
                            $item['UF_PLANE'] = CFile::GetPath($item['UF_PLANE']);
                        }
                        if (!empty($item['UF_GALLERY']) && is_array($item['UF_GALLERY'])) {
                            foreach ($item['UF_GALLERY'] as $idx => $fileId) {
                                $item['UF_GALLERY'][$idx] = CFile::GetPath($fileId);
                            }
                        }
                        $value['VALUE_ELEMENT'] = $item;
                    }
                }
            }
        }
    } unset($value);

    if(!empty($arResult['PROPERTIES']['PROJECTS']['VALUE'])) {
        $projectIds = [];
        foreach($arResult['PROPERTIES']['PROJECTS']['VALUE'] as $value) {
            $projectIds[] = $value;
        }
        $arResult['PROPERTIES']['PROJECTS']['VALUE_ELEMENTS'] = getProjects($projectIds, $roomsForJsOffers);
    }
}

//получаем дополнительные постройки
if(!empty($arResult['PROPERTIES']['BUILDINGS']['VALUE'])) {
    $tableName = $arResult['PROPERTIES']['BUILDINGS']['USER_TYPE_SETTINGS']['TABLE_NAME'];

    foreach($arResult['PROPERTIES']['BUILDINGS']['VALUE'] as $building) {
        $item = getHlData($building, $tableName);
        if($item !== null) {
            if(!empty($item['UF_GALLERY'])) {
                foreach($item['UF_GALLERY'] as $key => $img) {
                    $item['UF_GALLERY'][$key] = CFile::GetPath($img);
                }
            }
            if(!empty($item['UF_PLANE'])) {
                $item['UF_PLANE'] = CFile::GetPath($item['UF_PLANE']);
            }
            $arResult['PROPERTIES']['BUILDINGS']['VALUE_ITEMS'][$building] = $item;
        }
    }
}

//p($arResult['PROPERTIES']);

//формируем и уникализируем массив из свойств для вывода
if(isset($arResult['VARIATIONS']) && !empty($arResult['VARIATIONS'])) {
    $props = [];
    $uniqueValues = [];
    $activeVariationValues = [];

    foreach($arResult['VARIATIONS'] as $variation) {
        $isActiveVariation = ($variation['ACTIVE'] ?? 'Y') === 'Y';

        if(!empty($variation['PROPERTIES'])) {
            foreach($variation['PROPERTIES'] as $key => $prop) {
                if (strpos($key, 'HOUSES_') !== false) {
                    if (!isset($props[$key])) {
                        $props[$key] = [];
                    }
                    if (!isset($uniqueValues[$key])) {
                        $uniqueValues[$key] = [];
                    }
                    if (!isset($activeVariationValues[$key])) {
                        $activeVariationValues[$key] = [];
                    }
                    
                    if (!in_array($prop['VALUE'], $uniqueValues[$key])) {
                        if($prop['USER_TYPE'] == 'directory') {
                            $valueId = $prop['VALUE'];
                            $tableName = $prop['USER_TYPE_SETTINGS']['TABLE_NAME'];
                            if($valueId && $tableName) {
                                $item = getHlData($valueId, $tableName);
                                $prop['VALUE_ELEMENT'] = $item;
                            }
                        }
                        $uniqueValues[$key][] = $prop['VALUE'];
                        $props[$key][] = $prop;
                    }
                    if ($isActiveVariation && !in_array($prop['VALUE'], $activeVariationValues[$key])) {
                        $activeVariationValues[$key][] = $prop['VALUE'];
                    }
                }
            }
        }
    }

    foreach ($props as $propKey => &$propValues) {
        foreach ($propValues as &$propValue) {
            if (!in_array($propValue['VALUE'], $activeVariationValues[$propKey])) {
                $propValue['HIDDEN'] = 'Y';
            } else {
                $propValue['HIDDEN'] = 'N';
            }
        }
        unset($propValue);
    }
    unset($propValues);
}

$arResult['PROPS'] = $props;
//p($arResult['PROPS']);
//формируем массив с комбинациями
if(!empty($arResult['PROPS']) && !empty($arResult['VARIATIONS'])) {
    $arResult['JS_OFFERS'] = [];
    
    foreach($arResult['VARIATIONS'] as $variation) {
        $offer = [
            'ID' => $variation['ID'],
            'NAME' => $variation['NAME'],
            'PREVIEW_TEXT' => $variation['PREVIEW_TEXT'],
            'ACTIVE' => $variation['ACTIVE'],
            'PROPERTIES' => [],
            'COMBINATION' => []
        ];

        foreach($variation['PROPERTIES'] as $key => $value) {
            if ($value['USER_TYPE'] == 'HTML' && isset($value['VALUE']['TEXT'])) {
                $value['VALUE'] = $value['VALUE']['TEXT'];
            }
            if($key === 'GALLERY' || strpos($key, '_IMAGES') !== false || strpos($key, '_IMG') !== false) {
                if(is_array($value['VALUE'])) {
                    $images_data = [];
                    foreach($value['VALUE'] as $index => $img_id) {
                        $file_path = CFile::GetPath($img_id);
                        $description = $value['DESCRIPTION'][$index] ?? '';
                        
                        $images_data[] = [
                            'PATH' => $file_path,
                            'DESCRIPTION' => $description
                        ];
                    }
                    $value['VALUE'] = $images_data;
                } else {
                    $value['VALUE'] = CFile::GetPath($value['VALUE']);
                }
            }

            if ($key === 'PROJECTS' && !empty($value['VALUE'])) {
                $projectIds = is_array($value['VALUE']) ? $value['VALUE'] : [$value['VALUE']];
                $projectIds = array_unique($projectIds);

                $value['VALUE_ELEMENTS'] = getProjects($projectIds, $roomsForJsOffers);
            }

            if($value['USER_TYPE'] == 'directory') {
                $tableName = $value['USER_TYPE_SETTINGS']['TABLE_NAME'];
                if($value['MULTIPLE'] == 'Y' && !empty($value['VALUE'])) {
                    foreach($value['VALUE'] as $el) {
                        $valueId = $el;
                        $item = getHlData($valueId, $tableName);
                        $value['VALUE_ELEMENT'][] = $item;
                    }
                } else {
                    $valueId = $value['VALUE'];
                    if($valueId && $tableName) {
                        $item = getHlData($valueId, $tableName);
                        $value['VALUE_ELEMENT'] = $item;
                    }
                }
            }
            $offer['PROPERTIES'][$key] = $value;
            if(strpos($key, 'HOUSES_') !== false && !empty($value['VALUE'])) {
                $value_id = $value['VALUE_ENUM_ID'] ? $value['VALUE_ENUM_ID'] : $value['VALUE'];
                $offer['COMBINATION'][] = $key . ':' . $value_id; 
            }
        }
        /*
        if(!empty($variation['PROPERTIES']['PROJECT']['VALUE'])) {
            $arSelect = array(
                "ID", 
                "IBLOCK_ID", 
                "NAME",
                "PREVIEW_TEXT",
                "DETAIL_PAGE_URL",
                "PROPERTY_HOUSES_SQUARES",
                "PROPERTY_HOUSES_SIZES",
                "PROPERTY_HOUSES_ROOMS"
            );
            $arFilter = array("ID" => $variation['PROPERTIES']['PROJECT']['VALUE'], "ACTIVE" => "Y");

            $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
            $value['VALUE_ELEMENTS'] = [];
            while($element = $res->fetch()) {
                if(!empty($element['DETAIL_PAGE_URL'])) {
                    $element['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl(
                        $element['DETAIL_PAGE_URL'], 
                        $element, 
                        false, 
                        "E"
                    );
                }
                $offer['PROPERTIES']['PROJECT']['VALUE_ELEMENTS'][] = $element;
            }
        }
        */

        sort($offer['COMBINATION']);
        $combinationKey = implode('|', $offer['COMBINATION']);
        $offer['COMBINATION_KEY'] = $combinationKey;
        $arResult['JS_OFFERS'][$combinationKey] = $offer;
    }
}

//p($arResult);