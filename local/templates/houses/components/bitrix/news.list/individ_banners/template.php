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
	$counter = 1;
?>
<section class="section individual-ms">
	<div class="container">
		<div class="individual-ms__slider-wrap">
			<div class="splide individual-ms__slider">
				<div class="splide__track">
					<ul class="splide__list">
						<? foreach($arResult['ITEMS'] as $arItem): ?>
							<? if($counter == 1): ?>
							<li class="splide__slide">
								<div class="individual-ms__image">
									<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="Индивидуальный проект">
								</div>
								<h1 class="h1">
									<?= $arItem['DETAIL_TEXT']; ?>
								</h1>
								<a <?= !$arItem['DISPLAY_PROPERTIES']['BTN_LINK']['VALUE'] ? 'data-modal-target="#manager" href="javascript:void(0)"' : 'href="' . $arItem['DISPLAY_PROPERTIES']['BTN_LINK']['VALUE'] . '"'; ?> class="arrow-btn__dark">
									<span>
										<?= $arItem['DISPLAY_PROPERTIES']['BTN_TEXT']['VALUE'] ?>
									</span>
									<div class="icon">
										<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<path
												d="M15.4167 10L10.4167 15M5 10H15.4167H5ZM15.4167 10L10.4167 5L15.4167 10Z"
												stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
												stroke-linejoin="round"></path>
										</svg>
									</div>
								</a>
							</li>
							<? else: ?>
							<li class="splide__slide">
								<div class="individual-ms__image">
									<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="Индивидуальный проект">
								</div>
								<div class="individual-ms__info">
									<div class="individual-ms__info-title">
										<?= $arItem['NAME'] ?>
									</div>
									<div class="individual-ms__info-text">
										<?= $arItem['PREVIEW_TEXT'] ?>
									</div>
									<div class="individual-ms__info-icon">
										<img src="<?= $arItem['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
									</div>
								</div>
							</li>
							<? endif; ?>
							<? $counter++; ?>
						<? endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<? endif; ?>