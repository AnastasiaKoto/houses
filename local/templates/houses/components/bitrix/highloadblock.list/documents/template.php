<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */


if (!empty($arResult['ERROR'])) {
	echo $arResult['ERROR'];
	return false;
}
if(!empty($arResult['rows'])):
?>
<section class="section documents">
	<div class="container">
		<h1>
			<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
					"AREA_FILE_SHOW" => "file", 
					"AREA_FILE_SUFFIX" => "",
					"EDIT_TEMPLATE" => "standard.php",
					"PATH" => "/include/docs/docs-title.php" 
				)
			); ?>
		</h1>
		<div class="documents-description">
			<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
					"AREA_FILE_SHOW" => "file", 
					"AREA_FILE_SUFFIX" => "",
					"EDIT_TEMPLATE" => "standard.php",
					"PATH" => "/include/docs/docs-descr.php" 
				)
			); ?>
		</div>
		<div class="documents-items">
			<? foreach($arResult['rows'] as $row): ?>
			<div class="documents-item">
				<div class="documents-item__icon">
					<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M5.33301 28.5307V3.46406C5.33301 3.02224 5.69118 2.66406 6.13301 2.66406H21.6683C21.8805 2.66406 22.0839 2.74834 22.2339 2.89838L26.4321 7.09641C26.5821 7.24645 26.6663 7.44993 26.6663 7.6621V28.5307C26.6663 28.9726 26.3082 29.3307 25.8663 29.3307H6.13301C5.69118 29.3307 5.33301 28.9726 5.33301 28.5307Z"
							stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						<path
							d="M21.333 7.1974V3.13546C21.333 2.87512 21.5441 2.66406 21.8045 2.66406C21.9294 2.66406 22.0493 2.71373 22.1378 2.80213L26.5282 7.19266C26.6167 7.28106 26.6663 7.40097 26.6663 7.526C26.6663 7.78634 26.4553 7.9974 26.1949 7.9974H22.133C21.6911 7.9974 21.333 7.63922 21.333 7.1974Z"
							fill="#8E9293" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round"
							stroke-linejoin="round" />
						<path d="M10.667 13.3359H21.3337" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round"
							stroke-linejoin="round" />
						<path d="M10.667 24H21.3337" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round"
							stroke-linejoin="round" />
						<path d="M10.667 18.6641H16.0003" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round"
							stroke-linejoin="round" />
					</svg>
				</div>
				<div class="documents-item_name">
					<?= $row['UF_NAME']; ?>
				</div>
				<div class="documents-item__description">
					<?= $row['UF_DESCR']; ?>
				</div>
				<a href="<?= $row['UF_PDF']; ?>" target="_blank" class="documents-item__link">
					<span>
						Посмотреть PDF
					</span>
					<svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.33333 5.5L5.33333 9.5M1 5.5H9.33333H1ZM9.33333 5.5L5.33333 1.5L9.33333 5.5Z"
							stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>
			</div>
			<? endforeach; ?>
		</div>
	</div>
</section>
<? endif; ?>