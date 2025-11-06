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
if(!empty($arResult["rows"])):
?>
<section class="section individual-start">
	<div class="container">
		<div class="individual-start__inner">
			<div class="individual-start__info">
				<div class="section-title">
					<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
							"AREA_FILE_SHOW" => "file", 
							"AREA_FILE_SUFFIX" => "",
							"EDIT_TEMPLATE" => "standard.php",
							"PATH" => "/include/individ_page/start_project/section_title.php" 
						)
					); ?>
				</div>
				
				<ul class="individual-start__info-items">
					<? foreach ($arResult["rows"] as $row): ?>
					<li class="individual-start__info-item">
						<span class="individual-start__info-item__icon">
							<img src="<?= $row['UF_ICON']; ?>" alt="С ваших идей и устных пожеланий">
						</span>
						<span class="individual-start__info-item__text">
							<?= $row['UF_NAME']; ?>
						</span>
					</li>
					<? endforeach; ?>
				</ul>
			</div>
			<div class="individual-start__image">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
						"AREA_FILE_SHOW" => "file", 
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/individ_page/start_project/section_image.php" 
					)
				); ?>
			</div>
		</div>
	</div>
</section>
<? endif; ?>