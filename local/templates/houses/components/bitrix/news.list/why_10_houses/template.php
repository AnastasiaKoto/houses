<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if (!empty($arResult['ITEMS'])):
	?>
	<section class="section about-why">
		<div class="container">
			<div class="section-title">
				<? $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/company/10domov/section_title.php"
					)
				); ?>
			</div>
			<div class="section-subtitle">
				<? $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/company/10domov/section_descr.php"
					)
				); ?>
			</div>
			<div class="splide about-why__slider" id="aboutWhySlider">
				<div class="splide__track">
					<ul class="splide__list about-why__items">
						<? foreach($arResult['ITEMS'] as $arItem): ?>
						<li class="about-why__item <?= !$arItem['PROPERTIES']['LIGHT']['VALUE'] == 'Да' ? 'light' : ''; ?>">
							<div class="about-why__item-image">
								<picture>
									<source srcset="<?= $arItem['DETAIL_PICTURE']['SRC'] ? $arItem['DETAIL_PICTURE']['SRC'] : $arItem['PREVIEW_PICTURE']['SRC']; ?>" media="(max-width: 768px)">
									<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
								</picture>
							</div>
							<div class="about-why__item-title">
								<?= $arItem['NAME']; ?>
							</div>
							<div class="about-why__item-description">
								<?= $arItem['~PREVIEW_TEXT']; ?>
							</div>
						</li>
						<? endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="about-why__slider-arrows">
				<button class="slider-arrow about-why__slider-arrow about-why__slider-arrow__prev">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.1667 5.75H0.75H11.1667ZM0.75 5.75L5.75 0.75L0.75 5.75ZM0.75 5.75L5.75 10.75Z"
							fill="#8E9293" />
						<path d="M0.75 5.75L5.75 10.75M11.1667 5.75H0.75H11.1667ZM0.75 5.75L5.75 0.75L0.75 5.75Z"
							stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</button>
				<button class="slider-arrow about-why__slider-arrow about-why__slider-arrow__next">
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