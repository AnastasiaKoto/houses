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
	<section class="section company-ms">
		<div class="container">
			<div class="company-ms__slider-wrap">
				<div class="splide company-ms__slider">
					<div class="splide__track">
						<ul class="splide__list">
							<? 
							foreach($arResult['ITEMS'] as $arItem): 
								if($arItem['PROPERTIES']['MAIN_SLIDE']['VALUE'] == 'Да'):
							?>
								<li class="splide__slide">
									<? if($arItem['PREVIEW_PICTURE']['SRC']): ?>
									<div class="company-ms__image">
										<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arItem['NAME']; ?>">
									</div>
									<? endif; ?>
									<h1 class="h1">
										<?= $arItem['DETAIL_TEXT'] ? $arItem['~DETAIL_TEXT'] : $arItem['NAME']; ?>
									</h1>
									<div class="company-ms__description">
										<?= $arItem['~PREVIEW_TEXT'] ?>
									</div>
									<a href="<?= $arItem['PROPERTIES']['BTN_LINK']['VALUE']; ?>" class="arrow-btn__dark">
										<span>
											<?= $arItem['PROPERTIES']['BTN_TEXT']['VALUE']; ?>
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
									<div class="company-ms__image">
										<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME']; ?>">
										<? if($arItem['PROPERTIES']['PICTURE_TYPE']['VALUE'] == 'Фоновое изображение'): ?>
										<div class="company-ms__image-layer"></div>
										<? endif; ?>
									</div>
									<div class="company-ms__info">
										<div class="company-ms__info-title">
											<?= $arItem['NAME']; ?>
										</div>
										<div class="company-ms__info-text">
											<?= $arItem['~PREVIEW_TEXT'] ?>
										</div>
									</div>
									<? if(!empty($arItem['PROPERTIES']['BTN_TEXT']['VALUE'])): ?>
									<a <?= $arItem['PROPERTIES']['BTN_LINK']['VALUE'] ? 'href="'.$arItem['PROPERTIES']['BTN_LINK']['VALUE'].'"' : 'data-modal-target="#manager" href="javascript:void(0)"'; ?> class="call-to-manager">
										<span>
											<?= $arItem['PROPERTIES']['BTN_TEXT']['VALUE']; ?>
										</span>
										<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12.3333 8L8.33333 12M4 8H12.3333H4ZM12.3333 8L8.33333 4L12.3333 8Z" stroke="#2E2F33"
											stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
										</svg>
									</a>
									<? endif; ?>
								</li>
								<? endif; ?>
							<? endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
<? endif; ?>