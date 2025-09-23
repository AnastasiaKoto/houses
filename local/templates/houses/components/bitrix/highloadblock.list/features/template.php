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
?>
<section class="section advantages">
	<div class="container">
		<div class="advantages-inner">
			<div class="section-title">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
						"AREA_FILE_SHOW" => "file", 
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/mainpage/features/features_title.php" 
					)
				);?>
			</div>
			<div class="section-subtitle">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
						"AREA_FILE_SHOW" => "file", 
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/mainpage/features/features_descr.php" 
					)
				);?>
			</div>
			<? if(!empty($arResult['rows'])): ?>
			<div class="advantages-items">
				<? foreach($arResult['rows'] as $row): 
				?>
				<div class="advantages-item">
					<div class="advantages-item__icon">
						<img src="<?= $row['UF_ICON']; ?>" alt="">
					</div>
					<div class="advantages-item__title">
						<?= $row['UF_TITLE']; ?>
					</div>
					<div class="advantages-item__description">
						<?= $row['UF_DESCR']; ?>
					</div>
				</div>
				<? endforeach; ?>
			</div>
			<? endif; ?>
		</div>
	</div>
</section>