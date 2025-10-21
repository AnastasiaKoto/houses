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
/*
echo '<pre>';
print_r($arResult['ITEMS']);
echo '</pre>';
*/
?>
<section class="section mainscreen">
	<div class="container">
		<? if(!empty($arResult['ITEMS'])): 
			foreach($arResult['ITEMS'] as $arItem):
		?>
		<div class="mainscreen-inner">
			<div class="mainscreen-main__banner">
				<div class="mainscreen-main__banner-info">
					<? if(!empty($arItem['DISPLAY_PROPERTIES']['FIRST_BANNER_TITLE'])): ?>
					<h1>
						<?= $arItem['DISPLAY_PROPERTIES']['FIRST_BANNER_TITLE']['~VALUE']['TEXT']; ?>
					</h1>
					<? endif; ?>
					<h4>
						<?= $arItem['~PREVIEW_TEXT']; ?>
					</h4>
				</div>
				<? if(!empty($arItem['DISPLAY_PROPERTIES']['BLACK_BTN_TXT']['DISPLAY_VALUE'])) { ?>
				<a href="/proekty-domov/" class="arrow-btn__dark">
					<span>
						<?= $arItem['DISPLAY_PROPERTIES']['BLACK_BTN_TXT']['DISPLAY_VALUE']; ?>
					</span>
					<div class="icon">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.4167 10L10.4167 15M5 10H15.4167H5ZM15.4167 10L10.4167 5L15.4167 10Z"
								stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</a>
				<? } ?>
				<? if(!empty($arItem['PREVIEW_PICTURE'])) { ?>
				<div class="mainscreen-main__banner-image">
					<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="img">
				</div>
				<? } ?>
			</div>
			<? if(!empty($arItem['PROPERTIES']['BANNER_SLIDES']['ARVALUE'])):
			?>
			<div class="mainscreen-slider">
				<div class="splide mainscreen-splide">
					<div class="splide__track">
						<ul class="splide__list">
							<? foreach($arItem['PROPERTIES']['BANNER_SLIDES']['ARVALUE'] as $project): ?>
							<li class="splide__slide" onclick="window.location='<?= $project['UF_LINK']; ?>'">
								<div class="mainscreen-splide__image">
									<img src="<?= $project['UF_IMAGE']; ?>" alt="<?= $project['UF_NAME']; ?>">
								</div>
								<div class="mainscreen-splide__info">
									<div class="mainscreen-splide__info-title">
										<?= $project['UF_NAME']; ?>
									</div>
									<div class="mainscreen-splide__info-price">
										<?= $project['UF_DESCRIPTION']; ?>
									</div>
								</div>
							</li>
							<? endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<? endif; ?>
			<div class="mainscreen-small__banner">
				<? if(!empty($arItem['DETAIL_PICTURE'])): ?>
				<div class="mainscreen-small__banner-image">
					<img src="<?= $arItem['DETAIL_PICTURE']['SRC']; ?>" alt="<?= $arItem['DISPLAY_PROPERTIES']['SMALL_BANNER_TITLE']['~VALUE']; ?>">
				</div>
				<? endif; ?>
				<div class="mainscreen-small__banner-info">
					<h4>
						<?= $arItem['DISPLAY_PROPERTIES']['SMALL_BANNER_TITLE']['~VALUE']; ?>
					</h4>
					<?= $arItem['~DETAIL_TEXT']; ?>
					<? if(!empty($arItem['DISPLAY_PROPERTIES']['TRANSPARENT_BTN_TXT']['DISPLAY_VALUE'])) { ?>
					<a href="javascript:void(0)" class="arrow-btn__light">
						<span>
							<?= $arItem['DISPLAY_PROPERTIES']['TRANSPARENT_BTN_TXT']['DISPLAY_VALUE']; ?>
						</span>
						<div class="icon">
							<svg width="13" height="12" viewBox="0 0 13 12" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z"
									stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
					</a>
					<? } ?>
				</div>
			</div>
		</div>
		<? 
		endforeach;
		endif; ?>
	</div>
</section>