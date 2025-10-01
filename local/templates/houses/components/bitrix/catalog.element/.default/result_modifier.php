<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Iblock\ElementTable;

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

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
            "PREVIEW_TEXT"
        );
        $arFilter = array("ID" => $variation_id, "ACTIVE" => "Y");

        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        if($obElement = $res->GetNextElement()) {
            $arElement = $obElement->GetFields();
            $arElement['PROPERTIES'] = $obElement->GetProperties();
            
            $arResult['VARIATIONS'][] = $arElement;
        }
    }
}

//формируем и уникализируем массив из свойств для вывода
if(isset($arResult['VARIATIONS']) && !empty($arResult['VARIATIONS'])) {
    $props = [];
    $uniqueValues = [];
    foreach($arResult['VARIATIONS'] as $variation) {
        if(!empty($variation['PROPERTIES'])) {
            foreach($variation['PROPERTIES'] as $key => $prop) {
                if (strpos($key, 'HOUSES_') !== false) {
                    if (!isset($props[$key])) {
                        $props[$key] = [];
                    }
                    if (!isset($uniqueValues[$key])) {
                        $uniqueValues[$key] = [];
                    }
                    
                    if (!in_array($prop['VALUE'], $uniqueValues[$key])) {
                        $uniqueValues[$key][] = $prop['VALUE'];
                        $props[$key][] = $prop;
                    }
                }
            }
        }
    }
}

$arResult['PROPS'] = $props;

//формируем массив с комбинациями
if(!empty($arResult['PROPS']) && !empty($arResult['VARIATIONS'])) {
    $arResult['JS_OFFERS'] = [];
    
    foreach($arResult['VARIATIONS'] as $variation) {
        $offer = [
            'ID' => $variation['ID'],
            'NAME' => $variation['NAME'],
            'PREVIEW_TEXT' => $variation['PREVIEW_TEXT'],
            'PROPERTIES' => [],
            'COMBINATION' => []
        ];

        foreach($variation['PROPERTIES'] as $key => $value) {
            $offer['PROPERTIES'][$key] = $value;
            if(strpos($key, 'HOUSES_') !== false) {
                $value_id = $value['VALUE_ENUM_ID'] ? $value['VALUE_ENUM_ID'] : $value['VALUE'];
                $offer['COMBINATION'][] = $key . ':' . $value_id; 
            }
        }

        sort($offer['COMBINATION']);
        $combinationKey = implode('|', $offer['COMBINATION']);
        $offer['COMBINATION_KEY'] = $combinationKey;
        $arResult['JS_OFFERS'][$combinationKey][] = $offer;
    }
}

p($arResult['JS_OFFERS']);