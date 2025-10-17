<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |	Attention!
 * |	The following comments are for system use
 * |	and are required for the component to work correctly in ajax mode:
 * |	<!-- items-container -->
 * |	<!-- pagination-container -->
 * |	<!-- component-end -->
 */
$APPLICATION->AddChainItem($arResult["NAME"]);
$this->setFrameMode(true);
if (!empty($arResult['ITEMS'])):
	?>
	<div class="news-items">
		<? foreach($arResult['ITEMS'] as $arItem): ?>
		<div class="news-item" onclick="window.location='<?= $arItem['DETAIL_PAGE_URL']; ?>'">
			<div class="news-item__image">
				<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="img">
			</div>
			<div class="news-item__body">
				<div class="news-item__theme">
					<?= $arResult["NAME"]; ?>
				</div>
				<div class="news-item__name">
					<?= $arItem['NAME']; ?>
				</div>
				<div class="news-item__description">
					<?= $arItem['PREVIEW_TEXT']; ?>
				</div>
				<div class="news-item__bottom">
					<div class="news-item__date">
						<?
						$timestamp = MakeTimeStamp($arItem['DATE_CREATE'], "DD.MM.YYYY HH:MI:SS");
						$dateOnly = FormatDate("d.m.Y", $timestamp);
						?>
						<?= $dateOnly; ?>
					</div>
					<a href="<?= $arItem['DETAIL_PAGE_URL']; ?>" class="news-item__link">
						Подробнее
					</a>
				</div>
			</div>
		</div>
		<? endforeach; ?>
	</div>
<? endif; ?>