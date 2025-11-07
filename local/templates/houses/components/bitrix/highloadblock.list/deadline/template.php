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
	<section class="section crystal">
		<div class="container">
			<div class="crystal-head">
				<div class="section-title">
					<? $APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						array(
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "",
							"EDIT_TEMPLATE" => "standard.php",
							"PATH" => "/include/company/deadline/section_title.php"
						)
					); ?>
				</div>
				<a href="/proekty-domov/" class="arrow-btn__light">
					<span>
						Выбрать дом
					</span>
					<div class="icon">
						<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M11.9167 6L6.91667 11M1.5 6H11.9167H1.5ZM11.9167 6L6.91667 1L11.9167 6Z" stroke="white"
								stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</a>
			</div>
		</div>
		<div class="splide crystal-slider" id="crystalSlider">
			<div class="splide__track">
				<ul class="splide__list crystal-slider__items">
					<? foreach($arResult['rows'] as $row): ?>
					<li class="crystal-slider__item">
						<div class="crystal-slider__item-image">
							<picture>
								<source srcset="<?= $row['UF_IMG_MOBILE'] ? $row['UF_IMG_MOBILE'] : $row['UF_IMG']; ?>" media="(max-width: 768px)">
								<img src="<?= $row['UF_IMG']; ?>"
									alt="<?= $row['UF_NAME']; ?>">
							</picture>
						</div>
						<div class="crystal-slider__item-info">
							<div class="crystal-slider__item-title">
								<?= $row['UF_NAME']; ?>
							</div>
							<div class="crystal-slider__item-text">
								<?= $row['UF_DESCR']; ?>
							</div>
						</div>
					</li>
					<? endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="container">
			<div class="crystal__slider-arrows">
				<button class="slider-arrow crystal__slider-arrow crystal__slider-arrow__prev">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.1667 5.75H0.75H11.1667ZM0.75 5.75L5.75 0.75L0.75 5.75ZM0.75 5.75L5.75 10.75Z"
							fill="#8E9293" />
						<path d="M0.75 5.75L5.75 10.75M11.1667 5.75H0.75H11.1667ZM0.75 5.75L5.75 0.75L0.75 5.75Z"
							stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</button>
				<button class="slider-arrow crystal__slider-arrow crystal__slider-arrow__next">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M0.75 5.75H11.1667H0.75ZM11.1667 5.75L6.16667 0.75L11.1667 5.75ZM11.1667 5.75L6.16667 10.75Z"
							fill="#8E9293" />
						<path
							d="M11.1667 5.75L6.16667 10.75M0.75 5.75H11.1667H0.75ZM11.1667 5.75L6.16667 0.75L11.1667 5.75Z"
							stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</button>
			</div>
		</div>
	</section>
<? endif; ?>