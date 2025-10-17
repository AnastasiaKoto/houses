<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock")) {
    return;
}

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        if (!empty($arItem['PROPERTIES']['BANNER_SLIDES']['VALUE'])) {
            $projectIds = $arItem['PROPERTIES']['BANNER_SLIDES']['VALUE'];
            $products = [];
            if (!is_array($projectIds)) {
                $projectIds = array($projectIds);
            }

            foreach($projectIds as $projectId) {
                $products[] = getHlData($projectId, 'BannerSlides');

                foreach($products as $product) {
                    if($product['UF_IMAGE']) {

                        $product['UF_IMAGE'] = CFile::getPath($product['UF_IMAGE']);

                        $arItem['PROPERTIES']['BANNER_SLIDES']['ARVALUE'][] = $product;
                    }
                }
            }
        }
    }
    unset($arItem);
}
?>