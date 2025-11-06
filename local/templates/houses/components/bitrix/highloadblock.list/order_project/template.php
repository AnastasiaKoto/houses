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
if (!empty($arResult['rows'])):
	?>
	<section class="section why-order">
		<div class="container">
			<div class="section-title">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
						"AREA_FILE_SHOW" => "file", 
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/individ_page/order_project/section_title.php" 
					)
				); ?>
			</div>
			<ul class="why-order__items">
				<?
				foreach ($arResult["rows"] as $row): ?>
				<li class="why-order__item">
					<span class="why-order__item-num">
					</span>
					<span class="why-order__item-name">
						<?= $row['UF_NAME'] ?>
					</span>
					<div class="why-order__item-description">
						<?= $row['UF_DESCR'] ?>
					</div>
					<div class="why-order__item-icon">
						<img src="<?= $row['UF_ICON'] ?>" alt="<?= $row['UF_NAME'] ?>">
					</div>
				</li>
				<? endforeach; ?>
			</ul>
			<a href="javasscript:void(0)" class="arrow-btn__light" data-modal-target="#manager">
				<span>
					Заказать консультацию
				</span>
				<div class="icon">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M11.1667 5.75L6.16667 10.75M0.75 5.75H11.1667H0.75ZM11.1667 5.75L6.16667 0.75L11.1667 5.75Z"
							stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
			</a>
		</div>
	</section>
<? endif; ?>