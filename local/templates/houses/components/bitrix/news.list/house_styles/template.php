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
if(!empty($arResult['ITEMS'])):
?>
<section class="section styles">
	<div class="container">
		<div class="styles-inner">
			<div class="section-title">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
						"AREA_FILE_SHOW" => "file", 
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/mainpage/styles/styles_title.php" 
					)
				);?>
			</div>
			<div class="section-subtitle">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
						"AREA_FILE_SHOW" => "file", 
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/mainpage/styles/styles_descr.php" 
					)
				);?>
			</div>
		</div>
	</div>
	<div class="splide styles-slider">
		<div class="splide__track">
			<ul class="splide__list styles-items">
				<? foreach($arResult['ITEMS'] as $arItem): ?>
				<div class="splide__slide styles-item">
					<div class="styles-item__image">
						<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arItem['NAME']; ?>">
					</div>
					<div class="styles-item__body">
						<div class="styles-item__name">
							<?= $arItem['NAME']; ?>
						</div>
						<div class="styles-item__description">
							<?= $arItem['~PREVIEW_TEXT']; ?>
						</div>
						<a href="javascript:void(0)" class="arrow-btn__light">
							<span>
								<?= $arItem['PROPERTIES']['BTN_TXT']['VALUE']; ?>
							</span>
							<div class="icon">
								<svg width="13" height="12" viewBox="0 0 13 12" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z"
										stroke="white" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
								</svg>
							</div>
						</a>
					</div>
				</div>
				<? endforeach; ?>
			</ul>
		</div>
		<div class="styles-arrows">
			<div class="styles-arrow styles-arrow__prev">
				<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.4167 6H1H11.4167ZM1 6L6 1L1 6ZM1 6L6 11Z" fill="#8E9293" />
					<path d="M1 6L6 11M11.4167 6H1H11.4167ZM1 6L6 1L1 6Z" stroke="#8E9293" stroke-width="1.5"
						stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</div>
			<div class="styles-arrow styles-arrow__next">
				<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6ZM11.4167 6L6.41667 11Z" fill="#8E9293" />
					<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="#8E9293"
						stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</div>
		</div>
	</div>

</section>
<? endif; ?>