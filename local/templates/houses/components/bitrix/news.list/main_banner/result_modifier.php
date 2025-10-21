<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock")) {
    return;
}

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        if (!empty($arItem['PROPERTIES']['BANNER_SLIDES']['VALUE'])) {
            $projectIds = $arItem['PROPERTIES']['BANNER_SLIDES']['VALUE'];
            
            if (!is_array($projectIds)) {
                $projectIds = array($projectIds);
            }

            // Очищаем массив перед заполнением
            $arItem['PROPERTIES']['BANNER_SLIDES']['ARVALUE'] = [];
            
            foreach($projectIds as $projectId) {
                $product = getHlData($projectId, 'BannerSlides');
                
                if($product && $product['UF_IMAGE']) {
                    $product['UF_IMAGE'] = CFile::getPath($product['UF_IMAGE']);
                    $arItem['PROPERTIES']['BANNER_SLIDES']['ARVALUE'][] = $product;
                }
            }
        }
    }
    unset($arItem);
}
?>