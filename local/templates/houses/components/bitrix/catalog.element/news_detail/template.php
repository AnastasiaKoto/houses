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
 * @var string $templateFolder
 */

$this->setFrameMode(true);
?>
<section class="section news-detail">
	<div class="container">
		<h1>
			<?= $arResult['NAME']; ?>
		</h1>
		<div class="news-detail__inner">
			<div class="news-detail-content">
				<img src="<?= $arResult['DETAIL_PICTURE']['SRC']; ?>" alt="img">
				<br /><br /><br /><br />
				<?= $arResult['~DETAIL_TEXT']; ?>
			</div>
			<div class="news-detail__side-wrap">
				<div class="news-detail__side">
					<div class="news-detail__side-title">
						Навигация
					</div>
					<div class="news-detail__side-links">
						<a href="javascript:void(0)" class="current">
						</a>
						<a href="javascript:void(0)">
						</a>
						<a href="javascript:void(0)">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
