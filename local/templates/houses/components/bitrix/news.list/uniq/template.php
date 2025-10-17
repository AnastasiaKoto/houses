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
<section class="section uniq">
	<div class="container">
		<div class="uniq-inner">
			<div class="uniq-head">
				<div class="section-title">
					<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
							"AREA_FILE_SHOW" => "file", 
							"AREA_FILE_SUFFIX" => "",
							"EDIT_TEMPLATE" => "standard.php",
							"PATH" => "/include/mainpage/uniq/unic_title.php" 
						)
					);?>
				</div>
				<div class="uniq-arrows">
					<div class="uniq-arrow uniq-arrow__prev">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.4167 10H5H15.4167ZM5 10L10 5L5 10ZM5 10L10 15Z" fill="#8E9293" />
							<path d="M5 10L10 15M15.4167 10H5H15.4167ZM5 10L10 5L5 10Z" stroke="#8E9293"
								stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
					<div class="uniq-arrow uniq-arrow__next">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5 10H15.4167H5ZM15.4167 10L10.4167 5L15.4167 10ZM15.4167 10L10.4167 15Z"
								fill="#8E9293" />
							<path d="M15.4167 10L10.4167 15M5 10H15.4167H5ZM15.4167 10L10.4167 5L15.4167 10Z"
								stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="uniq-slider__wrap">
		<div class="splide uniq-slider">
			<div class="splide__track">
				<ul class="splide__list">
					<? $counter = 1; ?>
					<? foreach($arResult['ITEMS'] as $arItem): ?>
					<li data-modal-target="#modal<?= $counter; ?>" class="splide__slide <?= $arItem['PROPERTIES']['TEXT_COLOR']['VALUE'] == 'Темный текст' ? 'dark-text' : '';  ?>">
						<div class="uniq-slider__image">
							<? if($arItem['PROPERTIES']['TEXT_COLOR']['VALUE'] !== 'Темный текст'): ?>
							<div class="uniq-dark__layer"></div>
							<? endif ?>
							<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arItem['NAME']; ?>">
						</div>
						<div class="uniq-slider__name">
							<?= $arItem['NAME']; ?>
						</div>
						<div class="uniq-slider__Description">
							<?= $arItem['~PREVIEW_TEXT']; ?>
						</div>
					</li>
					<? if(!empty($arItem['DETAIL_TEXT'])): ?>
					<div class="modal" id="modal<?= $counter; ?>">
						<div class="modal-inner">
							<div class="modal-content">
								<?= $arItem['~DETAIL_TEXT']; ?>
							</div>
							<button class="modal-close">
							Закрыть окно
							</button>
						</div>
					</div>
					<? endif; ?>
					<? $counter++; endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<? endif; ?>