<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
$this->addExternalJs('/local/templates/houses/components/bitrix/catalog.element/.default/ajax.js');

$haveOffers = isset($arResult['JS_OFFERS']) && !empty($arResult['JS_OFFERS']) ? true : false;

if ($haveOffers) {
	$currentOffer = [];
	foreach ($arResult['JS_OFFERS'] as $offer) {
		if($offer['ACTIVE'] == 'Y') {
			$currentOffer = $offer;
			break;
		}
	}

	$gallery = $currentOffer['PROPERTIES']['GALLERY']['VALUE'];
	$title = $currentOffer['PROPERTIES']['SHOWED_NAME']['VALUE'] ?? $currentOffer['NAME'];
	$price = (int)preg_replace('/[^\d]/', '', $currentOffer['PROPERTIES']['FORMATTED_PRICE']['VALUE']);
	$formatted_price = number_format($price, 0, ',', ' ') . ' ₽';
	$deadline = $currentOffer['PROPERTIES']['DEADLINE']['VALUE'];
	//планировка дома
	$square = $currentOffer['PROPERTIES']['HOUSES_SQUARES']['VALUE_ELEMENT']['UF_DESCRIPTION'] ?? 0;
	$sizes = $currentOffer['PROPERTIES']['SIZES']['VALUE'] ?? 0;
	$height = $currentOffer['PROPERTIES']['HEIGHT']['VALUE'] ?? 0;
	$detail_descr = $currentOffer['PREVIEW_TEXT'] ?? '';
	$rooms = $currentOffer['PROPERTIES']['ROOMS']['VALUE'] ?? '';
	$storages = $currentOffer['PROPERTIES']['STORAGE']['VALUE'] ?? '';
	$wcs = $currentOffer['PROPERTIES']['WCS']['VALUE'] ?? '';
	$planes = $currentOffer['PROPERTIES']['PLANE']['VALUE_ELEMENT'] ?? [];
	$recomendations = $currentOffer['PROPERTIES']['PROJECTS']['VALUE_ELEMENTS'];
} else {
	//p($arResult['PROPERTIES']);
	$gallery = $arResult['PROPERTIES']['GALLERY']['VALUE'];
	$title = $arResult['NAME'];
	$price = $arResult['PROPERTIES']['HOUSES_PRICES']['VALUE'][0];
	$formatted_price = !empty($price) ? number_format($price, 0, ',', ' ') . ' ₽' : '';
	$deadline = $arResult['PROPERTIES']['DEADLINE']['VALUE'];
	//планировка дома
	$square = $arResult['PROPERTIES']['HOUSES_SQUARES']['VALUE'][0] . ' м<sup>2</sup>' ?? 0;
	$sizes = $arResult['PROPERTIES']['HOUSES_SIZES']['VALUE'][0] ?? 0;
	$height = $arResult['PROPERTIES']['HEIGHT']['VALUE'] ?? 0;
	$detail_descr = $arResult['DETAIL_TEXT'] ?? '';
	$rooms = $arResult['PROPERTIES']['HOUSES_ROOMS']['VALUE'][0] ?? '';
	$storages = $arResult['PROPERTIES']['STORAGE']['VALUE'][0] ?? '';
	$wcs = $arResult['PROPERTIES']['HOUSES_WC']['VALUE'][0] ?? '';
	$planes = $arResult['PROPERTIES']['PLANES']['VALUE_ELEMENT'] ?? [];
	$recomendations = $arResult['PROPERTIES']['PROJECTS']['VALUE_ELEMENTS'];
	//p($recomendations);
}
?>
<section class="section detail-product__mainscreen" <? if ($haveOffers) {
	echo 'id="' . $currentOffer['COMBINATION_KEY'] . '"';
} ?>>
	<div class="container">
		<div class="detail-product__mainscreen-inner">
			<div class="detail-product__mainscreen-images">
				<? if($arParams['SECTION_ID'] == 9): ?>
					<? if(!empty($arResult['PROPERTIES']['TRANSLATION_LINK']['VALUE'])): ?>
					<a target="_blank" href="<?= $arResult['PROPERTIES']['TRANSLATION_LINK']['DESCRIPTION']; ?>" class="detail-product__mainscreen-video__link">
						<div class="detail-product__mainscreen-video__link-layer"></div>
						<div class="detail-product__mainscreen-video__link-play">
							<svg width="48" height="54" viewBox="0 0 48 54" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M47 26.134C47.6667 26.5189 47.6667 27.4811 47 27.866L2 53.8468C1.33333 54.2317 0.5 53.7506 0.5 52.9808V1.01924C0.5 0.249438 1.33333 -0.231687 2 0.153213L47 26.134Z"
								fill="white" />
							</svg>
							<div class="detail-product__mainscreen-video__link-text">
							Смотреть стройку в прямом эфире
							</div>
						</div>
						<img src="<?= CFile::GetPath($arResult['PROPERTIES']['TRANSLATION_LINK']['VALUE']); ?>" alt="img">
					</a>
					<? endif; ?>
				<? else: ?>
					<? if (!empty($gallery)): ?>
						<div class="splide detail__page-slider__images">
							<div class="splide__track">
								<ul class="splide__list detail__page-slider__image-items">
									<? foreach ($gallery as $arImage): ?>
										<li class="splide__slide detail__page-slider__image-item">
											<div class="detail__page-slider__image-layer"></div>
											<div class="detail__page-slider__image-description">
												<?= $arImage['DESCRIPTION']; ?>
											</div>
											<img src="<?= $arImage['PATH']; ?>" alt="img">
										</li>
									<? endforeach; ?>
								</ul>
							</div>
						</div>
					<? endif; ?>
				<? endif; ?>
			</div>
			<div class="detail-product__mainscreen-info">
				<h1 <? !$haveOffers ? 'class="detail-product__finished-h1"' : ''; ?>>
					<?= $title; ?>
				</h1>
				<? if ($haveOffers): ?>
					<div class="detail-product__mainscreen-spec-items">
						<? if (!empty($arResult['PROPS'])): ?>
							<div class="detail-product__mainscreen-spec-item">
								<div class="detail-product__mainscreen-config">
									<div class="detail-product__mainscreen-config__head">
										<div class="detail-product__mainscreen-config__head-title">
											Конфигурация дома
										</div>
										<button type="button" class="detail-product__mainscreen-config__head-change"
											data-move-target=".anchor-edit" data-move-break="700">
											Изменить
										</button>
									</div>
									<div class="detail-product__mainscreen-config__items">
										<? if (!empty($arResult['PROPS']['HOUSES_STYLE'])):
												$styleValue = '';
												foreach ($arResult['PROPS']['HOUSES_STYLE'] as $value):
													if (in_array('HOUSES_STYLE:' . $value['VALUE_ENUM_ID'], $currentOffer['COMBINATION'])):
														$styleValue = $value['VALUE'];
														break;
													endif;
												endforeach;
												if(!empty($styleValue)):?>
												<div class="detail-product__mainscreen-config__item" data-prop="style">
													<div class="detail-product__mainscreen-config__item-name">
														<?= $arResult['PROPS']['HOUSES_STYLE'][0]['NAME']; ?>
													</div>
													<div class="detail-product__mainscreen-config__item-devider"></div>
													<div class="detail-product__mainscreen-config__item-prop">
														<?= $styleValue;  ?>
													</div>		
												</div>
											<? endif; ?>
										<? endif; ?>

										<? if (!empty($arResult['PROPS']['HOUSES_FLOORS'])):
												$floorsValue = '';
												foreach ($arResult['PROPS']['HOUSES_FLOORS'] as $value):
													if (in_array('HOUSES_FLOORS:' . $value['VALUE_ENUM_ID'], $currentOffer['COMBINATION'])):
														$floorsValue = $value['VALUE'];
														break;
													endif;
												endforeach;
												if(!empty($floorsValue)):?>
												<div class="detail-product__mainscreen-config__item" data-prop="floors">
													<div class="detail-product__mainscreen-config__item-name">
														<?= $arResult['PROPS']['HOUSES_FLOORS'][0]['NAME']; ?>
													</div>
													<div class="detail-product__mainscreen-config__item-devider"></div>
													<div class="detail-product__mainscreen-config__item-prop">
														<?= $floorsValue; ?>
													</div>
												</div>
												<? endif; ?>
										<? endif; ?>

										<? if (!empty($arResult['PROPS']['HOUSES_SQUARES'])): 
											$squareValue = '';
											foreach ($arResult['PROPS']['HOUSES_SQUARES'] as $value):
												if (in_array('HOUSES_SQUARES:' . $value['VALUE'], $currentOffer['COMBINATION'])):
													$squareValue  = $value['VALUE_ELEMENT']['UF_DESCRIPTION'];
													break;
												endif;
											endforeach;
											if(!empty($squareValue)):?>
											<div class="detail-product__mainscreen-config__item" data-prop="area">
												<div class="detail-product__mainscreen-config__item-name">
													<?= $arResult['PROPS']['HOUSES_SQUARES'][0]['NAME']; ?>
												</div>
												<div class="detail-product__mainscreen-config__item-devider"></div>
												<div class="detail-product__mainscreen-config__item-prop">
													<?= $squareValue; ?>
												</div>
											</div>
											<? endif; ?>
										<? endif; ?>

									</div>
									<div class="detail-product__mainscreen-config__items edit">
										<? if (!empty($arResult['PROPS']['HOUSES_STYLE'])): 
											$show = false;
											foreach ($arResult['PROPS']['HOUSES_STYLE'] as $value) {
												if(!empty($value['VALUE'])) {
													$show = true;
													break;
												}
											}
											if($show):
										?>
											<div class="detail-product__mainscreen-config__item">
												<div class="detail-product__mainscreen-config__item-name">
													<?= $arResult['PROPS']['HOUSES_STYLE'][0]['NAME']; ?>
												</div>
												<div class="custom-radio">
													<? foreach ($arResult['PROPS']['HOUSES_STYLE'] as $value):
														$checked = in_array('HOUSES_STYLE:' . $value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : '';
														?>
														<label class="radio <?= $value['HIDDEN'] == 'Y' ? 'noactive' : ''; ?>">
															<input type="radio" id="HOUSES_STYLE:<?= $value['VALUE_ENUM_ID']; ?>"
																name="HOUSES_STYLE" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
															<span class="radio__text"><?= $value['VALUE']; ?></span>
														</label>
													<? endforeach; ?>
												</div>
											</div>
											<? endif; ?>
										<? endif; ?>
										<? if (!empty($arResult['PROPS']['HOUSES_FLOORS'])): 
											$show = false;
											foreach ($arResult['PROPS']['HOUSES_FLOORS'] as $value) {
												if(!empty($value['VALUE'])) {
													$show = true;
													break;
												}
											}
											if($show):
										?>
											<div class="detail-product__mainscreen-config__item">
												<div class="detail-product__mainscreen-config__item-name">
													<?= $arResult['PROPS']['HOUSES_FLOORS'][0]['NAME']; ?>
												</div>
												<div class="custom-radio">
													<? foreach ($arResult['PROPS']['HOUSES_FLOORS'] as $value):
														$checked = in_array('HOUSES_FLOORS:' . $value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : ''; ?>
														<label class="radio <?= $value['HIDDEN'] == 'Y' ? 'noactive' : ''; ?>">
															<input type="radio" id="HOUSES_FLOORS:<?= $value['VALUE_ENUM_ID']; ?>"
																name="HOUSES_FLOORS" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
															<span class="radio__text"><?= $value['VALUE']; ?></span>
														</label>
													<? endforeach; ?>
												</div>
											</div>
											<? endif; ?>
										<? endif; ?>
										<? if (!empty($arResult['PROPS']['HOUSES_SQUARES'])): 
											$show = false;
											foreach ($arResult['PROPS']['HOUSES_SQUARES'] as $value) {
												if(!empty($value['VALUE_ELEMENT'])) {
													$show = true;
													break;
												}
											}
											if($show):
										?>
											<div class="detail-product__mainscreen-config__item">
												<div class="detail-product__mainscreen-config__item-name">
													<?= $arResult['PROPS']['HOUSES_SQUARES'][0]['NAME']; ?>
												</div>
												<div class="custom-select-js">
													<? foreach ($arResult['PROPS']['HOUSES_SQUARES'] as $value): ?>
														<? if (in_array('HOUSES_SQUARES:' . $value['VALUE'], $currentOffer['COMBINATION'])): ?>
															<div class="selected"><strong><?= $value['VALUE_ELEMENT']['UF_DESCRIPTION']; ?></strong> <?= $value['VALUE_ELEMENT']['UF_FULL_DESCRIPTION']; ?></div>
															<input type="hidden" name="HOUSES_SQUARES"
																value="<?= $value['VALUE_ELEMENT']['UF_DESCRIPTION']; ?>">
															<?
															break;
														endif; ?>
													<? endforeach; ?>
													<ul class="options">
														<? foreach ($arResult['PROPS']['HOUSES_SQUARES'] as $value):
															$checked = in_array('HOUSES_SQUARES:' . $value['VALUE'], $currentOffer['COMBINATION']) ? 'active' : ''; ?>
															<li id="HOUSES_SQUARES:<?= $value['VALUE'] ?>"
																class="HOUSES_OPTION <?= $checked; ?> <?= $value['HIDDEN'] == 'Y' ? 'noactive' : ''; ?>"
																data-value="<?= $value['VALUE_ELEMENT']['UF_DESCRIPTION']; ?>"
																class="<?= $checked; ?>">
																<strong><?= $value['VALUE_ELEMENT']['UF_DESCRIPTION']; ?></strong>
																<?= $value['VALUE_ELEMENT']['UF_FULL_DESCRIPTION']; ?>
															</li>
														<? endforeach; ?>
													</ul>
												</div>
											</div>
											<? endif; ?>
										<? endif; ?>
									</div>
									<div class="anchor-edit"></div>
								</div>
							</div>
							<div class="detail-product__mainscreen-spec-item">
								<div class="detail-product__mainscreen-view">
									<div class="detail-product__mainscreen-view__head">
										<div class="detail-product__mainscreen-view__head-title">
											Отделка дома
										</div>
									</div>
									<div class="detail-product__mainscreen-view__items">
										<? if (!empty($arResult['PROPS']['HOUSES_FACADE'])): 
											$show = false;
											foreach ($arResult['PROPS']['HOUSES_FACADE'] as $value) {
												if(!empty($value['VALUE'])) {
													$show = true;
													break;
												}
											}
											if($show):
										?>
											<div class="detail-product__mainscreen-view__item">
												<div class="detail-product__mainscreen-view__item-name">
													<?= $arResult['PROPS']['HOUSES_FACADE'][0]['NAME']; ?>
												</div>
												<div class="custom-radio">
													<? foreach ($arResult['PROPS']['HOUSES_FACADE'] as $value):
														$checked = in_array('HOUSES_FACADE:' . $value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : ''; ?>
														<label class="radio <?= $value['HIDDEN'] == 'Y' ? 'noactive' : ''; ?>">
															<input type="radio" id="HOUSES_FACADE:<?= $value['VALUE_ENUM_ID']; ?>"
																name="HOUSES_FACADE" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
															<span class="radio__text"><?= $value['VALUE']; ?></span>
														</label>
													<? endforeach; ?>
												</div>
											</div>
											<? endif; ?>
										<? endif; ?>
										<? if (!empty($arResult['PROPS']['HOUSES_OTDELKA'])): 
											$show = false;
											foreach ($arResult['PROPS']['HOUSES_OTDELKA'] as $value) {
												if(!empty($value['VALUE'])) {
													$show = true;
													break;
												}
											}
											if($show):
										?>
											<div class="detail-product__mainscreen-view__item">
												<div class="detail-product__mainscreen-view__item-name">
													<?= $arResult['PROPS']['HOUSES_OTDELKA'][0]['NAME']; ?>
												</div>
												<div class="custom-radio">
													<? foreach ($arResult['PROPS']['HOUSES_OTDELKA'] as $value):
														$checked = in_array('HOUSES_OTDELKA:' . $value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : ''; ?>
														<label class="radio <?= $value['HIDDEN'] == 'Y' ? 'noactive' : ''; ?>">
															<input type="radio" id="HOUSES_OTDELKA:<?= $value['VALUE_ENUM_ID']; ?>"
																name="HOUSES_OTDELKA" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
															<span class="radio__text"><?= $value['VALUE']; ?></span>
														</label>
													<? endforeach; ?>
												</div>
											</div>
											<? endif; ?>
										<? endif; ?>
										<? if (!empty($arResult['PROPS']['HOUSES_OTDELKA_STYLE'])): 
											$show = false;
											foreach ($arResult['PROPS']['HOUSES_OTDELKA_STYLE'] as $value) {
												if(!empty($value['VALUE'])) {
													$show = true;
													break;
												}
											}
											if($show):
										?>
											<div class="detail-product__mainscreen-view__item">
												<div class="detail-product__mainscreen-view__item-name">
													<?= $arResult['PROPS']['HOUSES_OTDELKA_STYLE'][0]['NAME']; ?>
												</div>
												<div class="custom-radio">
													<? foreach ($arResult['PROPS']['HOUSES_OTDELKA_STYLE'] as $value):
														$checked = in_array('HOUSES_OTDELKA_STYLE:' . $value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : ''; ?>
														<label class="radio <?= $value['HIDDEN'] == 'Y' ? 'noactive' : ''; ?>">
															<input type="radio"
																id="HOUSES_OTDELKA_STYLE:<?= $value['VALUE_ENUM_ID']; ?>"
																name="HOUSES_OTDELKA_STYLE" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
															<span class="radio__text"><?= $value['VALUE']; ?></span>
														</label>
													<? endforeach; ?>
												</div>
											</div>
											<? endif; ?>
										<? endif; ?>
									</div>
								</div>
							</div>
						<? endif; ?>
						<? if (!empty($arResult['PROPERTIES']['BUILDINGS']['VALUE_ITEMS'])): ?>
							<div class="detail-product__mainscreen-spec-item">
								<div class="detail-product__mainscreen-addidional">
									<div class="detail-product__mainscreen-addidional__head">
										<div class="detail-product__mainscreen-addidional__head-title">
											<?= $arResult['PROPERTIES']['BUILDINGS']['NAME']; ?>
										</div>
									</div>
									<div class="custom-select-bubbles-js">
										<div class="selected">Выберите вариант</div>
										<ul class="options">
											<? foreach ($arResult['PROPERTIES']['BUILDINGS']['VALUE_ITEMS'] as $arItem): 
												if(!empty($arItem['UF_NAME'])):
											?>
												<li data-price="<?= $arItem['UF_PRICE']; ?>"
													data-deadline="<?= $arItem['UF_DEADLINE']; ?>"
													data-value="<?= $arItem['UF_XML_ID']; ?>">
													<span><?= $arItem['UF_NAME']; ?></span> <span
														class="price"><?= '+' . number_format($arItem['UF_PRICE'], 0, ',', ' ') . '₽'; ?></span>
												</li>
											<? endif;
											endforeach; ?>
										</ul>
										<div class="selected-bubbles"></div>
									</div>

								</div>
							</div>
						<? endif; ?>
					</div>
				<? else: ?>
					<div class="detail-product__finished-config">
						<div class="detail-product__finished-config__title">
							Конфигурация дома
						</div>
						<div class="detail-product__finished-config__items">
							<? if (!empty($arResult['PROPERTIES']['HOUSES_STYLE']['VALUE'])): ?>
								<div class="detail-product__finished-config__item">
									<div class="detail-product__finished-config__item-label">
										Стиль постройки
									</div>
									<div class="detail-product__finished-config__item-value">
										<?= $arResult['PROPERTIES']['HOUSES_STYLE']['VALUE'][0]; ?>
									</div>
								</div>
							<? endif; ?>
							<? if (!empty($arResult['PROPERTIES']['HOUSES_SQUARES']['VALUE'])): ?>
								<div class="detail-product__finished-config__item">
									<div class="detail-product__finished-config__item-label">
										Площадь дома
									</div>
									<div class="detail-product__finished-config__item-value">
										<?= $arResult['PROPERTIES']['HOUSES_SQUARES']['VALUE'][0]; ?> м<sup>2</sup>
									</div>
								</div>
							<? endif; ?>
							<? if (!empty($arResult['PREVIEW_TEXT'])): ?>
								<div class="detail-product__finished-config__item">
									<div class="detail-product__finished-config__item-label">
										Адрес
									</div>
									<div class="detail-product__finished-config__item-value">
										<?= $arResult['PREVIEW_TEXT']; ?>
									</div>
								</div>
							<? endif; ?>
						</div>
					</div>
				<? endif; ?>
				<div class="detail-product__mainscreen-total">
					<div class="detail-product__mainscreen-total__head">
						<div class="detail-product__mainscreen-total__item">
							<div class="detail-product__mainscreen-total__item-title">
								Итоговая стоимость
							</div>
							<div data-final-price="<?= $price; ?>"
								class="detail-product__mainscreen-total__item-value detail-product__mainscreen-total__item-price">
								<?= $formatted_price; ?>
							</div>
						</div>
						<div class="detail-product__mainscreen-total__item">
							<div class="detail-product__mainscreen-total__item-title">
								Срок строительства
							</div>
							<div data-final-deadline="<?= $deadline ?>"
								class="detail-product__mainscreen-total__item-value detail-product__mainscreen-total__item-date">
								<?= $deadline ? $deadline . ' дней' : ''; ?>
							</div>
						</div>
						<a href="javascript:void(0)" data-modal-target="#manager" class="ask-btn order-house">
							Заказать дом
						</a>
					</div>
					<?/*
				  <div class="detail-product__mainscreen-total__credit">
					  <div class="detail-product__mainscreen-total__credit-info">
						  <span>Семейная ипотека </span> от 22 500₽ / месяц
					  </div>
					  <a href="javascript:void(0)" class="detail-product__mainscreen-total__credit-link">
						  <span>
							  Выбрать условия
						  </span>
						  <svg width="11" height="11" viewBox="0 0 11 11" fill="none"
							  xmlns="http://www.w3.org/2000/svg">
							  <path d="M9.33333 5.5L5.33333 9.5M1 5.5H9.33333H1ZM9.33333 5.5L5.33333 1.5L9.33333 5.5Z"
								  stroke="#54B8F0" stroke-width="1.5" stroke-linecap="round"
								  stroke-linejoin="round" />
						  </svg>
					  </a>
				  </div>
				  */ ?>
				</div>
			</div>
		</div>
</section>

<section class="section detail-product__layout">
	<div class="container">
		<div class="detail-product__layout-inner">
			<div class="detail-product__layout-info">
				<div class="section-title" data-move-target=".anchor-title" data-move-break="992">
					Планировка дома
				</div>
				<div class="detail-product__layout-spec">
					<? if ($square): ?>
						<div class="detail-product__layout-spec__item">
							<div class="detail-product__layout-spec__item-name">
								Площадь дома
							</div>
							<div class="detail-product__layout-spec__item-value square-value">
								<?= $square; ?>
							</div>
						</div>
					<? endif; ?>
					<? if ($sizes): ?>
						<div class="detail-product__layout-spec__item">
							<div class="detail-product__layout-spec__item-name">
								Габариты
							</div>
							<div class="detail-product__layout-spec__item-value size-value">
								<?= $sizes; ?>
							</div>
						</div>
					<? endif; ?>
					<? if ($height): ?>
						<div class="detail-product__layout-spec__item">
							<div class="detail-product__layout-spec__item-name">
								Высота потолков
							</div>
							<div class="detail-product__layout-spec__item-value height-value">
								<?= $height; ?>
							</div>
						</div>
					<? endif; ?>
				</div>
				<div class="detail-product__layout-description">
					<?= $detail_descr; ?>
				</div>
				<button class="desc-toggle" style="display:none;">Показать больше</button>
				<div class="detail-product__layout-additional-options">
					<div class="detail-product__layout-additional-option">
						<div class="detail-product__layout-additional-option__title">
							Наполнение дома
						</div>
						<div class="detail-product__layout-additional-option__components">
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<div class="icon">
										<img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/bed.svg" alt="img">
									</div>
									<span>
										Комнаты
									</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div
									class="detail-product__layout-additional-option__component-value detail-product__layout-additional-option__component-value-house rooms-value">
									<?= $rooms; ?> шт
								</div>
							</div>
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<div class="icon">
										<img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/box.svg" alt="img">
									</div>
									<span>
										Кладовки
									</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div
									class="detail-product__layout-additional-option__component-value detail-product__layout-additional-option__component-value-house storages-value">
									<?= $storages; ?> шт
								</div>
							</div>
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<div class="icon">
										<img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/bath.svg" alt="img">
									</div>
									<span>Санузлы</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div
									class="detail-product__layout-additional-option__component-value detail-product__layout-additional-option__component-value-house wcs-value">
									<?= $wcs; ?> шт
								</div>
							</div>
						</div>
					</div>
					<div
						class="detail-product__layout-additional-option detail-product__layout-additional-option-buildings <?= $haveOffers ? 'hidden' : ''; ?>">
						<div class="detail-product__layout-additional-option__title">
							Дополнительные постройки
						</div>
						<div class="detail-product__layout-additional-option__components">
							<? if (!$haveOffers && !empty($arResult['PROPERTIES']['BUILDINGS']['VALUE_ELEMENT'])): ?>
							<? foreach($arResult['PROPERTIES']['BUILDINGS']['VALUE_ELEMENT'] as $arElement): ?>
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<span>
										<?= $arElement['UF_NAME']; ?>
									</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div class="detail-product__layout-additional-option__component-value">
									<?= $arElement['UF_SQUARE']; ?> м<sup>2</sup>
								</div>
							</div>
							<? endforeach; ?>
							<? endif; ?>
						</div>
					</div>
				</div>
			</div>
			<? if (!empty($planes)): ?>
				<div class="detail-product__layout-tabs">
					<div class="detail-product__layout-tabs__content">
						<?
						$count = 1;
						foreach ($planes as $plane): ?>
							<div class="tab-pane <?= $count == 1 ? 'active' : ''; ?>" data-tab="<?= $count; ?>"
								data-type="house">
								<div class="detail-product__layout-tabs__image" data-fancybox href="<?= $plane['UF_FILE']; ?>">
									<img src="<?= $plane['UF_FILE']; ?>" alt="<?= $plane['UF_NAME']; ?>">
									<div class="detail-product__layout-tabs__image-view__icon">
										<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<path
												d="M7.5 9.16667H9.16667H7.5ZM10.8333 9.16667H9.16667H10.8333ZM9.16667 9.16667V7.5V9.16667ZM9.16667 9.16667V10.8333Z"
												fill="#8E9293" />
											<path
												d="M9.16667 9.16667V10.8333M7.5 9.16667H9.16667H7.5ZM10.8333 9.16667H9.16667H10.8333ZM9.16667 9.16667V7.5V9.16667Z"
												stroke="#8E9293" stroke-width="1.5" stroke-linecap="round"
												stroke-linejoin="round" />
											<path d="M13.3333 13.3359L16.6667 16.6693" stroke="#8E9293" stroke-width="1.5"
												stroke-linecap="round" stroke-linejoin="round" />
											<path
												d="M3.33334 9.16927C3.33334 12.3909 5.94502 15.0026 9.16668 15.0026C10.7803 15.0026 12.2409 14.3474 13.2969 13.2886C14.3493 12.2334 15 10.7773 15 9.16927C15 5.94761 12.3883 3.33594 9.16668 3.33594C5.94502 3.33594 3.33334 5.94761 3.33334 9.16927Z"
												stroke="#8E9293" stroke-width="1.5" stroke-linecap="round"
												stroke-linejoin="round" />
										</svg>
									</div>
								</div>
							</div>
							<? $count++; endforeach; ?>
						<? if (!$haveOffers && !empty($arResult['PROPERTIES']['BUILDINGS']['VALUE_ELEMENT'])): ?>
						<? foreach($arResult['PROPERTIES']['BUILDINGS']['VALUE_ELEMENT'] as $arElement): ?>
							<? if(!empty($arElement['UF_PLANE'])): ?>
								<div class="tab-pane <?= $count == 1 ? 'active' : ''; ?>" data-tab="<?= $count; ?>"
								data-type="building">
									<a class="detail-product__layout-tabs__image" data-fancybox href="<?= $arElement['UF_PLANE']; ?>">
										<img src="<?= $arElement['UF_PLANE']; ?>" alt="<?= $arElement['UF_NAME']; ?>">
										<div class="detail-product__layout-tabs__image-view__icon">
											<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<path
													d="M7.5 9.16667H9.16667H7.5ZM10.8333 9.16667H9.16667H10.8333ZM9.16667 9.16667V7.5V9.16667ZM9.16667 9.16667V10.8333Z"
													fill="#8E9293" />
												<path
													d="M9.16667 9.16667V10.8333M7.5 9.16667H9.16667H7.5ZM10.8333 9.16667H9.16667H10.8333ZM9.16667 9.16667V7.5V9.16667Z"
													stroke="#8E9293" stroke-width="1.5" stroke-linecap="round"
													stroke-linejoin="round" />
												<path d="M13.3333 13.3359L16.6667 16.6693" stroke="#8E9293" stroke-width="1.5"
													stroke-linecap="round" stroke-linejoin="round" />
												<path
													d="M3.33334 9.16927C3.33334 12.3909 5.94502 15.0026 9.16668 15.0026C10.7803 15.0026 12.2409 14.3474 13.2969 13.2886C14.3493 12.2334 15 10.7773 15 9.16927C15 5.94761 12.3883 3.33594 9.16668 3.33594C5.94502 3.33594 3.33334 5.94761 3.33334 9.16927Z"
													stroke="#8E9293" stroke-width="1.5" stroke-linecap="round"
													stroke-linejoin="round" />
											</svg>
										</div>
									</a>
								</div>
							<? endif; ?>
						<? $count++; endforeach; ?>
						<? endif; ?>
					</div>

					<div class="detail-product__layout-tabs__links">
						<?
						$count = 1;
						foreach ($planes as $plane): ?>
							<a href="javascript:void(0)" data-type="house"
								class="detail-product__layout-tabs__link <?= $count == 1 ? 'active' : ''; ?>"
								data-tab="<?= $count; ?>"><?= $plane['UF_DESCRIPTION']; ?></a>
							<? $count++; endforeach; ?>
						<? if (!$haveOffers && !empty($arResult['PROPERTIES']['BUILDINGS']['VALUE_ELEMENT'])): ?>
						<? foreach($arResult['PROPERTIES']['BUILDINGS']['VALUE_ELEMENT'] as $arElement): ?>
							<? if(!empty($arElement['UF_PLANE'])): ?>
								<a href="javascript:void(0)" data-type="building"
								class="detail-product__layout-tabs__link <?= $count == 1 ? 'active' : ''; ?>"
								data-tab="<?= $count; ?>"><?= $arElement['UF_NAME']; ?></a>
						<? endif; ?>
						<? $count++; endforeach; ?>
						<? endif; ?>	
					</div>
				</div>
			<? endif ?>
			<div class="anchor-title"></div>
		</div>
	</div>
</section>
<? if ($haveOffers): ?>
	<section class="section detail-product__preview">
		<div class="container">
			<div class="detail-product__preview-head">
				<div class="section-title">
					Изображения проекта
				</div>
				<a href="javascript:void(0)" class="arrow-btn__dark" data-modal-target="#presentation"
					data-move-target=".btn-anchor" data-move-break="700">
					<span>
						Получить презентацию дома
					</span>
					<div class="icon">
						<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="black"
								stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</a>
			</div>
		</div>
		<?
		$imageTabs = [
			'FACADE_IMAGES' => [
				'number' => 1,
				'name' => 'Фасады'
			],
			'INTERJER_IMAGES' => [
				'number' => 2,
				'name' => 'Интерьеры'
			],
			'CUT_IMAGES' => [
				'number' => 3,
				'name' => 'Планировки'
			]
		];

		$foundActive = false;
		?>
		<div class="container">
			<div class="detail-product__preview-tabs">
				<div class="detail-product__preview-tabs__head">
					<div class="detail-product__preview-tabs__links">
						<? foreach ($imageTabs as $property => $config): ?>
							<? if (!empty($currentOffer['PROPERTIES'][$property])): ?>
								<?
								$isHidden = empty($currentOffer['PROPERTIES'][$property]['VALUE']);
								$isActive = !$isHidden && !$foundActive;
								
								if ($isActive) {
									$foundActive = true;
								}
								?>
								<a href="javascript:void(0)" class="detail-product__preview-tabs__link <?= $isActive ? 'active' : ''; ?> <?= $isHidden ? 'hidden' : ''; ?>" data-type="house" data-tab="<?= $config['number']; ?>">
									<?= $currentOffer['PROPERTIES'][$property]['NAME']; ?>
								</a>
							<? endif; ?>
						<? endforeach; ?>
					</div>
					<div class="detail-product__preview-arrows" data-move-target=".arrows-anchor" data-move-break="992">
						<div class="slider-arrow detail-product__preview-arrow detail-product__preview-arrow__prev">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M15.4167 10H5H15.4167ZM5 10L10 5L5 10ZM5 10L10 15Z" fill="#8E9293"></path>
								<path d="M5 10L10 15M15.4167 10H5H15.4167ZM5 10L10 5L5 10Z" stroke="#8E9293"
									stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</div>
						<div class="slider-arrow detail-product__preview-arrow detail-product__preview-arrow__next">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5 10H15.4167H5ZM15.4167 10L10.4167 5L15.4167 10ZM15.4167 10L10.4167 15Z"
									fill="#8E9293">
								</path>
								<path d="M15.4167 10L10.4167 15M5 10H15.4167H5ZM15.4167 10L10.4167 5L15.4167 10Z"
									stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
								</path>
							</svg>
						</div>
					</div>
				</div>
			</div>
		</div>

		<? 
		$foundActive = false; 
		?>

		<? foreach ($imageTabs as $property => $config): ?>
			<? if (!empty($currentOffer['PROPERTIES'][$property])): ?>
				<?
				$isHidden = empty($currentOffer['PROPERTIES'][$property]['VALUE']);
				$isActive = !$isHidden && !$foundActive;
				
				if ($isActive) {
					$foundActive = true;
				}
				?>
				<div class="detail-product__preview-tabs__content <?= $isActive ? 'active' : ''; ?> <?= $isHidden ? 'hidden' : ''; ?>"
					data-property="<?= $currentOffer['PROPERTIES'][$property]['CODE']; ?>" data-type="house" data-tab="<?= $config['number']; ?>">
					<div class="splide detail-product__preview-tabs__slider">
						<div class="splide__track">
							
							<ul class="splide__list">
								<? if (!empty($currentOffer['PROPERTIES'][$property]['VALUE'])): ?>
									<? foreach ($currentOffer['PROPERTIES'][$property]['VALUE'] as $img): ?>
										<a href="<?= $img['PATH']; ?>" data-fancybox class="splide__slide">
											<img src="<?= $img['PATH']; ?>" alt="img">
										</a>
									<? endforeach; ?>
								<? endif; ?>
							</ul>
							
						</div>
					</div>
				</div>
			<? endif; ?>
		<? endforeach; ?>
		<div class="container">
			<div class="arrows-anchor"></div>
			<div class="btn-anchor"></div>
		</div>
		<!--</div>-->
	</section>


	<section class="section equipment">
		<div class="container">
			<div class="equipment__head">
				<div class="section-title">
					Комплектация дома
				</div>
				<a href="javascript:void(0)" class="arrow-btn__dark" data-modal-target="#estimate"
					data-move-target=".eq-ancho-link" data-move-break="700">
					<span>
						Получить подробную смету
					</span>
					<div class="icon">
						<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="#000"
								stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</a>
			</div>
			<?
			$tabs = [
				'FUNDAMENT_CONFIG' => [
					'number' => 1,
					'img_property' => 'FUNDAMENT_IMG'
				],
				'WALLS_CONFIG' => [
					'number' => 2,
					'img_property' => 'WALLS_IMG'
				],
				'ROOF_CONFIG' => [
					'number' => 3,
					'img_property' => 'ROOF_IMG'
				],
				'INSULATION_CONFIG' => [
					'number' => 4,
					'img_property' => 'INSULATION_IMG'
				],
				'OUTER_FINISH_CONFIG' => [
					'number' => 5,
					'img_property' => 'OUTER_FINISH_IMG'
				],
				'DOORS_CONFIG' => [
					'number' => 6,
					'img_property' => 'DOORS_IMG'
				],
				'OTHER_CONFIG' => [
					'number' => 7,
					'img_property' => 'OTHER_IMG'
				]
			];

			$foundActive = false;
			?>
			<div class="equipment-tabs">
				<div class="equipment-tabs__links">
					<? foreach ($tabs as $property => $config): ?>
						<? if (!empty($currentOffer['PROPERTIES'][$property])): ?>
							<?
							$isHidden = empty($currentOffer['PROPERTIES'][$property]['VALUE']);
							$isActive = !$isHidden && !$foundActive;
							
							if ($isActive) {
								$foundActive = true;
							}
							?>
							<a href="javascript:void(0)" class="equipment-tabs__link <?= $isActive ? 'active' : ''; ?> <?= $isHidden ? 'hidden' : ''; ?>" data-type="house" data-tab="<?= $config['number']; ?>">
								<?= $currentOffer['PROPERTIES'][$property]['NAME']; ?>
							</a>
						<? endif; ?>
					<? endforeach; ?>
				</div>

				<? 
				$foundActive = false; 
				?>
				
				<? foreach ($tabs as $property => $config): ?>
					<? if (!empty($currentOffer['PROPERTIES'][$property])): ?>
						<?
						$isHidden = empty($currentOffer['PROPERTIES'][$property]['VALUE']);
						$isActive = !$isHidden && !$foundActive;
						
						if ($isActive) {
							$foundActive = true;
						}
						?>
						<div class="equipment-tabs__content <?= $isActive ? 'active' : ''; ?>" data-type="house"
							data-property="<?= $currentOffer['PROPERTIES'][$property]['CODE']; ?>" data-tab="<?= $config['number']; ?>">
							<div class="equipment-tabs__content-inner">
								<div class="equipment-tabs__content-acc">
									<?= htmlspecialcharsBack($currentOffer['PROPERTIES'][$property]['VALUE']); ?>
								</div>
								<? if (!empty($currentOffer['PROPERTIES'][$config['img_property']]['VALUE'])): ?>
									<div class="equipment-tabs__content-image">
										<img src="<?= $currentOffer['PROPERTIES'][$config['img_property']]['VALUE']; ?>" alt="img">
									</div>
								<? endif; ?>
							</div>
						</div>
					<? endif; ?>
				<? endforeach; ?>
				
				<div class="eq-ancho-link"></div>
			</div>
		</div>
	</section>
<? else: ?>
<? if(!empty($arResult['PROPERTIES']['VIDEO_POINT']) || !empty($arResult['PROPERTIES']['CONSTRUCT_POINT']) || !empty($arResult['PROPERTIES']['FINISHED_POINT']) || !empty($arResult['PROPERTIES']['END_POINT'])): 
?>
<section class="section detail-product__preview">
	<div class="container">
		<div class="detail-product__preview-head">
			<div class="section-title">
			Отчет по стройке
			</div>
		</div>
	</div>
	<div class="container">
		<div class="detail-product__preview-tabs">
			<div class="detail-product__preview-tabs__head">
			<div class="detail-product__preview-tabs__links">
				<? 
				$count = 1;
				foreach($arResult['PROPERTIES'] as $key => $prop): ?>
					<? if (strpos($key, '_POINT') !== false): ?>
					<a href="javascript:void(0)" class="detail-product__preview-tabs__link <?= $count === 1 ? 'active' : ''; ?>" data-tab="<?=$key;?>">
						<?= $prop['NAME'] ?>
					</a>
					<? $count++; endif; ?>
				<? endforeach; ?>
			</div>
			<div class="detail-product__preview-arrows" data-move-target=".arrows-anchor" data-move-break="992">
				<div class="detail-product__preview-arrow detail-product__preview-arrow__prev">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.4167 10H5H15.4167ZM5 10L10 5L5 10ZM5 10L10 15Z" fill="#8E9293"></path>
					<path d="M5 10L10 15M15.4167 10H5H15.4167ZM5 10L10 5L5 10Z" stroke="#8E9293" stroke-width="1.5"
					stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
				</div>
				<div class="detail-product__preview-arrow detail-product__preview-arrow__next">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 10H15.4167H5ZM15.4167 10L10.4167 5L15.4167 10ZM15.4167 10L10.4167 15Z" fill="#8E9293">
					</path>
					<path d="M15.4167 10L10.4167 15M5 10H15.4167H5ZM15.4167 10L10.4167 5L15.4167 10Z" stroke="#8E9293"
					stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
				</div>
			</div>
			</div>
		</div>
	</div>
	<? 
	$count = 1;
	foreach($arResult['PROPERTIES'] as $key => $prop): ?>
		<? if (strpos($key, '_POINT') !== false): 
			$active = $count === 1 ? 'active' : '';
			//p($prop);
		?>
			<? if($key === 'VIDEO_POINT'): ?>
				<div class="detail-product__preview-tabs__content <?= $active; ?>" data-tab="<?=$key;?>">
					<div class="splide detail-product__preview-tabs__slider">
						<div class="splide__track">
							<ul class="splide__list">
								<? foreach($prop['VALUE'] as $key => $value): ?>
								<li class="splide__slide">
									<div class="player-wrapper" data-video-id="<?= $prop['DESCRIPTION'][$key]; ?>">
										<img src="<?= CFile::GetPath($value); ?>" alt="Видео превью">
										<div class="player-play-btn">
										<svg width="47" height="55" viewBox="0 0 47 55" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path
											d="M46.5 26.634C47.1667 27.0189 47.1667 27.9811 46.5 28.366L1.5 54.3468C0.833332 54.7317 0 54.2506 0 53.4808V1.51924C0 0.749438 0.833332 0.268313 1.5 0.653213L46.5 26.634Z"
											fill="white" />
										</svg>
										<span>
											Смотреть в прямом эфире
										</span>
										</div>
										<div class="player-wrapper__layer"></div>
									</div>
								</li>
								<? endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			<? else: ?>
				<div class="detail-product__preview-tabs__content <?= $active; ?>" data-tab="<?=$key;?>">
					<div class="splide detail-product__preview-tabs__slider">
					<div class="splide__track">
						<ul class="splide__list">
							<? foreach($prop['VALUE'] as $value): ?>
							<li class="splide__slide">
								<img src="<?= CFile::GetPath($value); ?>" alt="img">
							</li>
							<? endforeach; ?>
						</ul>
					</div>
					</div>
				</div>
			<? endif; ?>
	<?  $count++; endif; ?>
	<? endforeach; ?>
	<div class="container">
		<div class="arrows-anchor"></div>
		<div class="btn-anchor"></div>
	</div>
</section>
<? endif; ?>
<? endif; ?>
<section class="<?= empty($recomendations) ? 'hidden' : ''; ?> section examples">
	<div class="container">
		<div class="examples-inner">
			<div class="section-title">
				Примеры реализованных проектов
			</div>
			<div class="section-subtitle">
				Посмотрите реальные фотографии проекта «Мейсон Классик» на разных этапах строительства — от заливки
				фундамента
				до готового дома.
			</div>

		</div>
	</div>
	<div class="splide examples-slider">
		<div class="splide__track">
			<ul class="splide__list examples-items projects-items">
				<? if (!empty($recomendations)): ?>
					<? foreach ($recomendations as $recomendation): ?>
						<div class="splide__slide examples-item projects-item" onclick="window.location='<?= $recomendation['DETAIL_PAGE_URL']; ?>'">
							<? if (!empty($recomendation['PROPERTY_GALLERY_VALUE'])): ?>
								<div class="splide projects-slider__images">
									<div class="splide__track">
										<ul class="splide__list projects-slider__image-items">
											<? foreach ($recomendation['PROPERTY_GALLERY_VALUE'] as $img): ?>
												<li class="splide__slide projects-slider__image-item">
													<img src="<?= $img; ?>" alt="img">
												</li>
											<? endforeach; ?>
										</ul>
									</div>
								</div>
							<? else: ?>
								<div class="catalog-item__no-images">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/no-photo.jpg" alt="not-image">
								</div>
							<? endif; ?>
							<div class="projects-item__body">
								<div class="projects-item__name">
									<?= $recomendation['NAME'] ?>
								</div>
								<div class="projects-item__description">
									<?= $recomendation['PREVIEW_TEXT'] ?>
								</div>
								<div class="projects-item__specs">
									<? if (!empty($recomendation['PROPERTY_HOUSES_SQUARES_VALUE'])): ?>
										<div class="projects-item__spec">
											<div class="projects-item__spec-name">
												Площадь
											</div>
											<div class="projects-item__spec-value">
												<?= $recomendation['PROPERTY_HOUSES_SQUARES_VALUE'][0]; ?> м<sup>2</sup>
											</div>
										</div>
									<? endif; ?>
									<? if (!empty($recomendation['PROPERTY_HOUSES_SIZES_VALUE'])): ?>
										<div class="projects-item__spec">
											<div class="projects-item__spec-name">
												Размер
											</div>
											<div class="projects-item__spec-value">
												<?= $recomendation['PROPERTY_HOUSES_SIZES_VALUE'][0]; ?> м
											</div>
										</div>
									<? endif; ?>
									<? if (!empty($recomendation['PROPERTY_HOUSES_ROOMS_VALUE'])): ?>
										<div class="projects-item__spec">
											<div class="projects-item__spec-name">
												Комнаты
											</div>
											<div class="projects-item__spec-value">
												<?= $recomendation['PROPERTY_HOUSES_ROOMS_VALUE'][0]; ?>
											</div>
										</div>
									<? endif; ?>
								</div>
							</div>
						</div>
					<? endforeach; ?>
				<? endif; ?>
			</ul>
		</div>
		<div class="examples-arrows">
			<div class="examples-arrow examples-arrow__prev">
				<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.4167 6H1H11.4167ZM1 6L6 1L1 6ZM1 6L6 11Z" fill="#8E9293" />
					<path d="M1 6L6 11M11.4167 6H1H11.4167ZM1 6L6 1L1 6Z" stroke="#8E9293" stroke-width="1.5"
						stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</div>
			<div class="examples-arrow examples-arrow__next">
				<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6ZM11.4167 6L6.41667 11Z" fill="#8E9293" />
					<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="#8E9293"
						stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</div>
		</div>
	</div>
</section>
<?
if ($haveOffers):
	?>
	<script>
		window.OFFERS_DATA = <?php echo json_encode($arResult['JS_OFFERS']); ?>;
		window.BUILDINGS_DATA = <?php echo json_encode($arResult['PROPERTIES']['BUILDINGS']['VALUE_ITEMS']); ?>;
		window.ACTIVE_COMBINATION_KEY = <?php echo json_encode($currentOffer['COMBINATION_KEY']); ?>;
		//console.log(OFFERS_DATA);
	</script>
<? endif; ?>
<script>
	const houseManager = new HouseVariationManager();
</script>