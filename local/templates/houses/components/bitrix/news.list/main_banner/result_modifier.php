<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock")) {
    return;
}

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        if (!empty($arItem['PROPERTIES']['PROJECTS']['VALUE'])) {
            $projectIds = $arItem['PROPERTIES']['PROJECTS']['VALUE'];
            if (!is_array($projectIds)) {
                $projectIds = array($projectIds);
            }

            $products = CIBlockElement::GetList(
                array("SORT" => "ASC"),
                array("ID" => $projectIds, "ACTIVE" => "Y"),
                false,
                false,
                array("ID", "PROPERTY_GALLERY", "PROPERTY_HOUSE_VARIABLES", "NAME")
            );

            $arItem['PROPERTIES']['PROJECTS']['ARVALUE'] = [];
            $processedIds = [];

            while ($product = $products->GetNext()) {
                if (in_array($product['ID'], $processedIds)) {
                    continue;
                }
                $processedIds[] = $product['ID'];
                
                if (!empty($product['PROPERTY_GALLERY_VALUE'])) {
                    $galleryValue = $product['PROPERTY_GALLERY_VALUE'];
                    
                    if (is_array($galleryValue) && !empty($galleryValue)) {
                        $firstImageId = $galleryValue[0];
                        if ($firstImageId > 0) {
                            $product['PREVIEW_PICTURE'] = CFile::GetPath($firstImageId);
                        }
                    } elseif ($galleryValue > 0) {
                        $product['PREVIEW_PICTURE'] = CFile::GetPath($galleryValue);
                    }
                }
                if (!empty($product['PROPERTY_HOUSE_VARIABLES_VALUE'])) {
                    $prices = [];
                    $res = CIBlockElement::GetList(
                        array("SORT" => "ASC"),
                        array("ID" => $product['PROPERTY_HOUSE_VARIABLES_VALUE'], "ACTIVE" => "Y"),
                        false,
                        false,
                        array("ID", "PROPERTY_FILTER_PRICE")
                    );

                    while ($arVariation = $res->GetNext()) {
                        $prices[] = $arVariation['PROPERTY_FILTER_PRICE_VALUE'];
                    }
                    $product['MIN_PRICE'] = !empty($prices) ? min($prices) : 0;
                } else {
                    $product['MIN_PRICE'] = 0;
                }
                $arItem['PROPERTIES']['PROJECTS']['ARVALUE'][] = $product;
            }
        }
    }
    unset($arItem);
}
?>