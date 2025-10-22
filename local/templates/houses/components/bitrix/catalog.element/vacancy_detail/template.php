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
<section class="section vacancy-detail">
	<div class="container">
		<div class="vacancy-detail__head">
			<div class="vacancy-detail__head-decor__bg">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/vac-d.png" alt="img">
			</div>
			<div class="vacancy-detail__head-decor">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/vac-ten.svg" alt="img">
			</div>
			<h1>
				<?= $arResult['NAME']; ?>
			</h1>
			<a href="#vacancy-form" class="no-ajax arrow-orange__link">
				<span>
					Откликнуться
				</span>
				<div class="icon">
					<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="#2E2F33"
							stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
			</a>
		</div>
		<div class="vacancy-detail__content">
			<?= $arResult['~DETAIL_TEXT']; ?>
		</div>
	</div>
</section>