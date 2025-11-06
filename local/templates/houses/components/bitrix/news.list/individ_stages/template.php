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
	<section class="section individual-steps">
		<div class="container">
			<div class="individual-steps__inner">
				<div class="section-title">
					<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
							"AREA_FILE_SHOW" => "file", 
							"AREA_FILE_SUFFIX" => "",
							"EDIT_TEMPLATE" => "standard.php",
							"PATH" => "/include/individ_page/stages/section_title.php" 
						)
					); ?>	
				</div>
				<ul class="individual-steps__items">
					<? foreach($arResult['ITEMS'] as $arItem): 
						$light_text = $arItem['DISPLAY_PROPERTIES']['LIGHT']['VALUE'] == 'Да' ? false : true;
					?>
					<li class="individual-steps__item <?= $light_text ? 'light' : ''; ?>">
						<div class="individual-steps__item-image">
							<?= $light_text ? '<div class="individual-steps__image-layer"></div>' : ''; ?>
							<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arItem['NAME']; ?>">
						</div>
						<div class="individual-steps__item-name">
							<?= $arItem['NAME']; ?>
						</div>
						<div class="individual-steps__item-text">
							<?= $arItem['~PREVIEW_TEXT']; ?>
						</div>
					</li>
					<? endforeach; ?>
				</ul>
			</div>
		</div>
	</section>
<? endif; ?>