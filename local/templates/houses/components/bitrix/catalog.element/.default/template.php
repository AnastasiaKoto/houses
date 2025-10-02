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

$haveOffers = isset($arResult['JS_OFFERS']) && !empty($arResult['JS_OFFERS']) ? true : false;

if($haveOffers) {
	$currentOffer = [];
	foreach($arResult['JS_OFFERS'] as $offer) {
		$currentOffer = $offer[0];
		break;
	}

	$gallery = $currentOffer['PROPERTIES']['GALLERY']['VALUE'];
	$title = $currentOffer['NAME'];
	$price = $currentOffer['PROPERTIES']['FORMATTED_PRICE']['VALUE'];
	$deadline = $currentOffer['PROPERTIES']['DEADLINE']['VALUE'];
} else {
	$title = $arResult['NAME'];
	$price = !empty($arResult['PROPERTIES']['HOUSES_PRICES']['VALUE']) ? number_format($arResult['PROPERTIES']['HOUSES_PRICES']['VALUE'][0], 0, ',', ' ') . ' ₽' : '';
	$deadline = $arResult['PROPERTIES']['DEADLINE']['VALUE'];
}
?>
<section class="section detail-product__mainscreen" <? if($haveOffers) { echo 'id="' . $currentOffer['COMBINATION_KEY'] . '"'; } ?>>
	<div class="container">
		<div class="detail-product__mainscreen-inner">
			<div class="detail-product__mainscreen-images">
				<? if(!empty($gallery)): ?>
				<div class="splide detail__page-slider__images">
					<div class="splide__track">
						<ul class="splide__list detail__page-slider__image-items">
							<? foreach($gallery as $arImage): ?>
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
			</div>
			<div class="detail-product__mainscreen-info">
				<h1>
					<?= $title; ?>
				</h1>
				<? if($haveOffers): ?>
				<div class="detail-product__mainscreen-spec-items">
					<? if(!empty($arResult['PROPS'])): ?>
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
								<? if(!empty($arResult['PROPS']['HOUSES_STYLE'])): ?>
								<div class="detail-product__mainscreen-config__item">
									<div class="detail-product__mainscreen-config__item-name">
										<?= $arResult['PROPS']['HOUSES_STYLE'][0]['NAME']; ?>
									</div>
									<div class="detail-product__mainscreen-config__item-devider"></div>
									<? foreach($arResult['PROPS']['HOUSES_STYLE'] as $value): 
										if(in_array('HOUSES_STYLE:'.$value['VALUE_ENUM_ID'], $currentOffer['COMBINATION'])):
									?>
									<div class="detail-product__mainscreen-config__item-prop">
										<?= $value['VALUE']; ?>
									</div>
									<?
									endif;
									break; 
									endforeach; ?>
								</div>
								<? endif; ?>

								<? if(!empty($arResult['PROPS']['HOUSES_FLOORS'])): ?>
								<div class="detail-product__mainscreen-config__item">
									<div class="detail-product__mainscreen-config__item-name">
										<?= $arResult['PROPS']['HOUSES_FLOORS'][0]['NAME']; ?>
									</div>
									<div class="detail-product__mainscreen-config__item-devider"></div>
									<? foreach($arResult['PROPS']['HOUSES_FLOORS'] as $value): 
										if(in_array('HOUSES_FLOORS:'.$value['VALUE_ENUM_ID'], $currentOffer['COMBINATION'])):
									?>
									<div class="detail-product__mainscreen-config__item-prop">
										<?= $value['VALUE']; ?>
									</div>
									<?
									endif;
									break; 
									endforeach; ?>
								</div>
								<? endif; ?>

								<? if(!empty($arResult['PROPS']['HOUSES_SQUARES'])): ?>
								<div class="detail-product__mainscreen-config__item">
									<div class="detail-product__mainscreen-config__item-name">
										<?= $arResult['PROPS']['HOUSES_SQUARES'][0]['NAME']; ?>
									</div>
									<div class="detail-product__mainscreen-config__item-devider"></div>
									<? foreach($arResult['PROPS']['HOUSES_SQUARES'] as $value): 
										if(in_array('HOUSES_SQUARES:'.$value['VALUE'], $currentOffer['COMBINATION'])):
									?>
									<div class="detail-product__mainscreen-config__item-prop">
										<?= $value['VALUE_ELEMENT']['UF_DESCRIPTION']; ?>
									</div>
									<?
									endif;
									break; 
									endforeach; ?>
								</div>
								<? endif; ?>

							</div>
							<div class="detail-product__mainscreen-config__items edit">
								<? if(!empty($arResult['PROPS']['HOUSES_STYLE'])): ?>
								<div class="detail-product__mainscreen-config__item">
									<div class="detail-product__mainscreen-config__item-name">
										<?= $arResult['PROPS']['HOUSES_STYLE'][0]['NAME']; ?>
									</div>
									<div class="custom-radio">
										<? foreach($arResult['PROPS']['HOUSES_STYLE'] as $value): 
											$checked = in_array('HOUSES_STYLE:'.$value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : '';
										?>
										<label class="radio">
											<input type="radio" id="HOUSES_STYLE:<?= $value['VALUE_ENUM_ID']; ?>" name="HOUSES_STYLE" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
											<span class="radio__text"><?= $value['VALUE']; ?></span>
										</label>
										<? endforeach; ?>
									</div>
								</div>
								<? endif; ?>
								<? if(!empty($arResult['PROPS']['HOUSES_FLOORS'])): ?>
								<div class="detail-product__mainscreen-config__item">
									<div class="detail-product__mainscreen-config__item-name">
										<?= $arResult['PROPS']['HOUSES_FLOORS'][0]['NAME']; ?>
									</div>
									<div class="custom-radio">
										<? foreach($arResult['PROPS']['HOUSES_FLOORS'] as $value): 
											$checked = in_array('HOUSES_FLOORS:'.$value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : ''; ?>
										<label class="radio">
											<input type="radio" id="HOUSES_FLOORS:<?= $value['VALUE_ENUM_ID']; ?>" name="HOUSES_FLOORS" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
											<span class="radio__text"><?= $value['VALUE']; ?></span>
										</label>
										<? endforeach; ?>
									</div>
								</div>
								<? endif; ?>
								<? if(!empty($arResult['PROPS']['HOUSES_SQUARES'])): ?>
								<div class="detail-product__mainscreen-config__item">
									<div class="detail-product__mainscreen-config__item-name">
										<?= $arResult['PROPS']['HOUSES_SQUARES'][0]['NAME']; ?>
									</div>
									<div class="custom-select-js">
										<? foreach($arResult['PROPS']['HOUSES_SQUARES'] as $value):  ?>
										<? if(in_array('HOUSES_SQUARES:'.$value['VALUE'], $currentOffer['COMBINATION'])): ?>
										<div class="selected"><?= $value['VALUE_ELEMENT']['UF_DESCRIPTION']; ?></div>
										<? endif; ?>
										<? endforeach; ?>
										<ul class="options">
											<? foreach($arResult['PROPS']['HOUSES_SQUARES'] as $value): 
											$checked = in_array('HOUSES_SQUARES:'.$value['VALUE'], $currentOffer['COMBINATION']) ? 'active' : ''; ?>
											<li data-value="<?= $value['VALUE_ELEMENT']['UF_DESCRIPTION']; ?>" class="<?= $checked; ?>">
												<strong><?= $value['VALUE_ELEMENT']['UF_DESCRIPTION']; ?></strong> <?= $value['VALUE_ELEMENT']['UF_FULL_DESCRIPTION']; ?>
											</li>
											<? endforeach; ?>
										</ul>
									</div>
								</div>
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
								<? if(!empty($arResult['PROPS']['HOUSES_FACADE'])): ?>
								<div class="detail-product__mainscreen-view__item">
									<div class="detail-product__mainscreen-view__item-name">
										<?= $arResult['PROPS']['HOUSES_FACADE'][0]['NAME']; ?>
									</div>
									<div class="custom-radio">
										<? foreach($arResult['PROPS']['HOUSES_FACADE'] as $value): 
											$checked = in_array('HOUSES_FACADE:'.$value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : ''; ?>
										<label class="radio">
											<input type="radio" id="HOUSES_FACADE:<?= $value['VALUE_ENUM_ID']; ?>" name="HOUSES_FACADE" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
											<span class="radio__text"><?= $value['VALUE']; ?></span>
										</label>
										<? endforeach; ?>
									</div>
								</div>
								<? endif; ?>
								<? if(!empty($arResult['PROPS']['HOUSES_OTDELKA'])): ?>
								<div class="detail-product__mainscreen-view__item">
									<div class="detail-product__mainscreen-view__item-name">
										<?= $arResult['PROPS']['HOUSES_OTDELKA'][0]['NAME']; ?>
									</div>
									<div class="custom-radio">
										<? foreach($arResult['PROPS']['HOUSES_OTDELKA'] as $value): 
											$checked = in_array('HOUSES_OTDELKA:'.$value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : ''; ?>
										<label class="radio">
											<input type="radio" id="HOUSES_OTDELKA:<?= $value['VALUE_ENUM_ID']; ?>" name="HOUSES_OTDELKA" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
											<span class="radio__text"><?= $value['VALUE']; ?></span>
										</label>
										<? endforeach; ?>
									</div>
								</div>
								<? endif; ?>
								<? if(!empty($arResult['PROPS']['HOUSES_OTDELKA_STYLE'])): ?>
								<div class="detail-product__mainscreen-view__item">
									<div class="detail-product__mainscreen-view__item-name">
										<?= $arResult['PROPS']['HOUSES_OTDELKA_STYLE'][0]['NAME']; ?>
									</div>
									<div class="custom-radio">
										<? foreach($arResult['PROPS']['HOUSES_OTDELKA_STYLE'] as $value): 
											$checked = in_array('HOUSES_OTDELKA_STYLE:'.$value['VALUE_ENUM_ID'], $currentOffer['COMBINATION']) ? 'checked' : ''; ?>
										<label class="radio">
											<input type="radio" id="HOUSES_OTDELKA_STYLE:<?= $value['VALUE_ENUM_ID']; ?>" name="HOUSES_OTDELKA_STYLE" value="<?= $value['VALUE']; ?>" <?= $checked; ?>>
											<span class="radio__text"><?= $value['VALUE']; ?></span>
										</label>
										<? endforeach; ?>
									</div>
								</div>
								<? endif; ?>
							</div>
						</div>
					</div>
					<? endif; ?>
					<? if(!empty($arResult['PROPERTIES']['BUILDINGS']['VALUE_ITEMS'])): ?>
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
									<? foreach($arResult['PROPERTIES']['BUILDINGS']['VALUE_ITEMS'] as $arItem): ?>
									<li data-value="<?= $arItem['UF_XML_ID']; ?>"><span><?= $arItem['UF_NAME']; ?></span> <span class="price"><?= '+' . number_format($arItem['UF_PRICE'], 0, ',', ' ') . '₽'; ?></span>
									</li>
									<? endforeach; ?>
								</ul>
								<div class="selected-bubbles"></div>
							</div>

						</div>
					</div>
					<? endif; ?>
				</div>
				<? endif; ?>
				<div class="detail-product__mainscreen-total">
					<div class="detail-product__mainscreen-total__head">
						<div class="detail-product__mainscreen-total__item">
							<div class="detail-product__mainscreen-total__item-title">
								Итоговая стоимость
							</div>
							<div class="detail-product__mainscreen-total__item-value">
								<?= $price; ?>
							</div>
						</div>
						<div class="detail-product__mainscreen-total__item">
							<div class="detail-product__mainscreen-total__item-title">
								Срок строительства
							</div>
							<div class="detail-product__mainscreen-total__item-value">
								<?= $deadline; ?>
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
					*/?>
				</div>
			</div>
		</div>
</section>
<?/*
<section class="section detail-product__layout">
	<div class="container">
		<div class="detail-product__layout-inner">
			<div class="detail-product__layout-info">
				<div class="section-title" data-move-target=".anchor-title" data-move-break="992">
					Планировка дома
				</div>
				<div class="detail-product__layout-spec">
					<div class="detail-product__layout-spec__item">
						<div class="detail-product__layout-spec__item-name">
							Площадь дома
						</div>
						<div class="detail-product__layout-spec__item-value">
							123 м<sup>2</sup>
						</div>
					</div>
					<div class="detail-product__layout-spec__item">
						<div class="detail-product__layout-spec__item-name">
							Габариты
						</div>
						<div class="detail-product__layout-spec__item-value">
							12 х 24 м
						</div>
					</div>
					<div class="detail-product__layout-spec__item">
						<div class="detail-product__layout-spec__item-name">
							Высота потолков
						</div>
						<div class="detail-product__layout-spec__item-value">
							3 м
						</div>
					</div>
				</div>
				<div class="detail-product__layout-description">
					Противоположная точка зрения подразумевает, что многие известные личности, инициированные
					исключительно
					синтетически, смешаны с не уникальными данными до степени совершенной неузнаваемости, из-за чего
					возрастает их статус бесполезности. Господа, понимание сути ресурсосберегающих технологий
					обеспечивает
					актуальность поставленных обществом задач. В своём стремлении улучшить пользовательский опыт мы
					упускаем,
					что стремящиеся вытеснить традиционное производство, нанотехнологии являются только методом
					политического
					участия и объявлены нарушающими общечеловеческие нормы этики и морали.
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
										<img src="./assets/img/bed.svg" alt="img">
									</div>
									<span>
										Комнаты
									</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div class="detail-product__layout-additional-option__component-value">
									4 шт
								</div>
							</div>
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<div class="icon">
										<img src="./assets/img/box.svg" alt="img">
									</div>
									<span>
										Кладовки
									</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div class="detail-product__layout-additional-option__component-value">
									4 шт
								</div>
							</div>
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<div class="icon">
										<img src="./assets/img/bath.svg" alt="img">
									</div>
									<span> Кладовки</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div class="detail-product__layout-additional-option__component-value">
									2 шт
								</div>
							</div>
						</div>
					</div>
					<div class="detail-product__layout-additional-option">
						<div class="detail-product__layout-additional-option__title">
							Дополнительные постройки
						</div>
						<div class="detail-product__layout-additional-option__components">
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<span>
										Гараж на два автомобиля
									</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div class="detail-product__layout-additional-option__component-value">
									30 м<sup>2</sup>
								</div>
							</div>
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<span>
										Баня
									</span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div class="detail-product__layout-additional-option__component-value">
									25 м<sup>2</sup>
								</div>
							</div>
							<div class="detail-product__layout-additional-option__component">
								<div class="detail-product__layout-additional-option__component-name">
									<span> Гостевой дом с баней </span>
								</div>
								<div class="detail-product__layout-additional-option__component-devider"></div>
								<div class="detail-product__layout-additional-option__component-value">
									12 м<sup>2</sup>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="detail-product__layout-tabs">
				<div class="detail-product__layout-tabs__content">
					<div class="tab-pane active" data-tab="1">
						<a class="detail-product__layout-tabs__image" data-fancybox href="./assets/img/lay.jpg">
							<img src="./assets/img/lay.jpg" alt="Превью 1">
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
					<div class="tab-pane" data-tab="2">
						<a class="detail-product__layout-tabs__image" data-fancybox href="./assets/img/lay.jpg">
							<img src="./assets/img/lay.jpg" alt="Превью 3">
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
					<div class="tab-pane" data-tab="3">
						<a class="detail-product__layout-tabs__image" data-fancybox href="./assets/img/lay.jpg">
							<img src="./assets/img/lay.jpg" alt="Превью 4">
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
					<div class="tab-pane" data-tab="4">
						<a class="detail-product__layout-tabs__image" data-fancybox href="./assets/img/lay.jpg">
							<img src="./assets/img/lay.jpg" alt="Превью 4">
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
					<div class="tab-pane" data-tab="5">
						<a class="detail-product__layout-tabs__image" data-fancybox href="./assets/img/lay.jpg">
							<img src="./assets/img/lay.jpg" alt="Превью 4">
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
				</div>

				<div class="detail-product__layout-tabs__links">
					<a href="#" class="detail-product__layout-tabs__link active" data-tab="1">1 этаж</a>
					<a href="#" class="detail-product__layout-tabs__link" data-tab="2">2 этаж</a>
					<a href="#" class="detail-product__layout-tabs__link" data-tab="3">Баня</a>
					<a href="#" class="detail-product__layout-tabs__link" data-tab="4">Гараж</a>
					<a href="#" class="detail-product__layout-tabs__link" data-tab="5">Гостевой дом</a>
				</div>
			</div>
			<div class="anchor-title"></div>
		</div>
	</div>
</section>
<section class="section detail-product__preview">
	<div class="container">
		<div class="detail-product__preview-head">
			<div class="section-title">
				Изображения проекта
			</div>
			<a href="javascript:void(0)" class="arrow-btn__light" data-modal-target="#presentation"
				data-move-target=".btn-anchor" data-move-break="700">
				<span>
					Получить презентацию дома
				</span>
				<div class="icon">
					<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="white"
							stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
			</a>
		</div>
	</div>
	<div class="container">
		<div class="detail-product__preview-tabs">
			<div class="detail-product__preview-tabs__head">
				<div class="detail-product__preview-tabs__links">
					<a href="javascript:void(0)" class="detail-product__preview-tabs__link active" data-tab="Фундамент">
						Фундамент
					</a>
					<a href="javascript:void(0)" class="detail-product__preview-tabs__link" data-tab="Интерьер">
						Интерьер
					</a>
					<a href="javascript:void(0)" class="detail-product__preview-tabs__link" data-tab="Разрезы">
						Разрезы
					</a>
					<a href="javascript:void(0)" class="detail-product__preview-tabs__link" data-tab="Гараж">
						Гараж
					</a>
					<a href="javascript:void(0)" class="detail-product__preview-tabs__link" data-tab="Баня">
						Баня
					</a>
					<a href="javascript:void(0)" class="detail-product__preview-tabs__link" data-tab="Гостевой дом">
						Гостевой дом
					</a>
				</div>
				<div class="detail-product__preview-arrows" data-move-target=".arrows-anchor" data-move-break="992">
					<div class="detail-product__preview-arrow detail-product__preview-arrow__prev">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.4167 10H5H15.4167ZM5 10L10 5L5 10ZM5 10L10 15Z" fill="#8E9293"></path>
							<path d="M5 10L10 15M15.4167 10H5H15.4167ZM5 10L10 5L5 10Z" stroke="#8E9293"
								stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
						</svg>
					</div>
					<div class="detail-product__preview-arrow detail-product__preview-arrow__next">
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
	<div class="detail-product__preview-tabs__content active" data-tab="Фундамент">
		<div class="splide detail-product__preview-tabs__slider">
			<div class="splide__track">
				<ul class="splide__list">
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre2.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre3.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="detail-product__preview-tabs__content" data-tab="Интерьер">
		<div class="splide detail-product__preview-tabs__slider">
			<div class="splide__track">
				<ul class="splide__list">
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre2.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre3.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="detail-product__preview-tabs__content" data-tab="Разрезы">
		<div class="splide detail-product__preview-tabs__slider">
			<div class="splide__track">
				<ul class="splide__list">
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre2.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre3.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="detail-product__preview-tabs__content" data-tab="Гараж">
		<div class="splide detail-product__preview-tabs__slider">
			<div class="splide__track">
				<ul class="splide__list">
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre2.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre3.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="detail-product__preview-tabs__content" data-tab="Баня">
		<div class="splide detail-product__preview-tabs__slider">
			<div class="splide__track">
				<ul class="splide__list">
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre2.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre3.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="detail-product__preview-tabs__content" data-tab="Гостевой дом">
		<div class="splide detail-product__preview-tabs__slider">
			<div class="splide__track">
				<ul class="splide__list">
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre2.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre3.jpg" alt="img">
					</li>
					<li class="splide__slide">
						<img src="./assets/img/pre1.jpg" alt="img">
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="arrows-anchor"></div>
		<div class="btn-anchor"></div>
	</div>
</section>
<section class="section equipment">
	<div class="container">
		<div class="equipment__head">
			<div class="section-title">
				Комплектация дома
			</div>
			<a href="javascript:void(0)" class="arrow-btn__light" data-modal-target="#estimate"
				data-move-target=".eq-ancho-link" data-move-break="700">
				<span>
					Получить подробную смету
				</span>
				<div class="icon">
					<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="white"
							stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
			</a>
		</div>
		<div class="equipment-tabs">
			<div class="equipment-tabs__links">
				<a href="javascript:void(0)" class="equipment-tabs__link active" data-tab="foundation">
					Фундамент
				</a>
				<a href="javascript:void(0)" class="equipment-tabs__link" data-tab="walls">
					Стены
				</a>
				<a href="javascript:void(0)" class="equipment-tabs__link" data-tab="roof">
					Кровля
				</a>
				<a href="javascript:void(0)" class="equipment-tabs__link" data-tab="uteplenie">
					Утепление
				</a>
				<a href="javascript:void(0)" class="equipment-tabs__link" data-tab="naruzhka">
					Наружняя отделка
				</a>
				<a href="javascript:void(0)" class="equipment-tabs__link" data-tab="window">
					Окна и двери
				</a>
				<a href="javascript:void(0)" class="equipment-tabs__link" data-tab="more">
					Другое
				</a>
			</div>
			<div class="equipment-tabs__content active" data-tab="foundation">
				<div class="equipment-tabs__content-inner">
					<div class="equipment-tabs__content-acc">
						<ul>
							<li>
								<dl>
									<dt>
										Выезд специалиста
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Привязка дома на участке
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Пробное бурение почвы
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Монтаж ж/б свай
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обустройство закладных
									</dt>
									<dd>
										Ввод воды 1 шт: гильза с уклоном не менее 10 мм/м на песчаной подушке
										с засыпкой.
										Ввод канализации 1 шт: выпускная канализационная труба с уклоном не менее 10
										мм/м на песчаной
										подушке с засыпкой
										Ввод эл-ва: труба ПНД 63 мм под ввод электричества, 10 м.п. на глубине не менее
										600 мм от
										поверхности грунта с сигнальной лентой
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обвязка фундамента антисептированным составным ростверком
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
						</ul>
					</div>
					<div class="equipment-tabs__content-image">
						<img src="./assets/img/acc.jpg" alt="img">
					</div>
				</div>
			</div>
			<div class="equipment-tabs__content" data-tab="walls">
				<div class="equipment-tabs__content-inner">
					<div class="equipment-tabs__content-acc">
						<ul>
							<li>
								<dl>
									<dt>
										Выезд специалиста
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Привязка дома на участке
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Пробное бурение почвы
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Монтаж ж/б свай
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обустройство закладных
									</dt>
									<dd>
										Ввод воды 1 шт: гильза с уклоном не менее 10 мм/м на песчаной подушке
										с засыпкой.
										Ввод канализации 1 шт: выпускная канализационная труба с уклоном не менее 10
										мм/м на песчаной
										подушке с засыпкой
										Ввод эл-ва: труба ПНД 63 мм под ввод электричества, 10 м.п. на глубине не менее
										600 мм от
										поверхности грунта с сигнальной лентой
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обвязка фундамента антисептированным составным ростверком
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
						</ul>
					</div>
					<div class="equipment-tabs__content-image">
						<img src="./assets/img/acc.jpg" alt="img">
					</div>
				</div>
			</div>
			<div class="equipment-tabs__content" data-tab="roof">
				<div class="equipment-tabs__content-inner">
					<div class="equipment-tabs__content-acc">
						<ul>
							<li>
								<dl>
									<dt>
										Выезд специалиста
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Привязка дома на участке
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Пробное бурение почвы
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Монтаж ж/б свай
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обустройство закладных
									</dt>
									<dd>
										Ввод воды 1 шт: гильза с уклоном не менее 10 мм/м на песчаной подушке
										с засыпкой.
										Ввод канализации 1 шт: выпускная канализационная труба с уклоном не менее 10
										мм/м на песчаной
										подушке с засыпкой
										Ввод эл-ва: труба ПНД 63 мм под ввод электричества, 10 м.п. на глубине не менее
										600 мм от
										поверхности грунта с сигнальной лентой
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обвязка фундамента антисептированным составным ростверком
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
						</ul>
					</div>
					<div class="equipment-tabs__content-image">
						<img src="./assets/img/acc.jpg" alt="img">
					</div>
				</div>
			</div>
			<div class="equipment-tabs__content" data-tab="uteplenie">
				<div class="equipment-tabs__content-inner">
					<div class="equipment-tabs__content-acc">
						<ul>
							<li>
								<dl>
									<dt>
										Выезд специалиста
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Привязка дома на участке
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Пробное бурение почвы
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Монтаж ж/б свай
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обустройство закладных
									</dt>
									<dd>
										Ввод воды 1 шт: гильза с уклоном не менее 10 мм/м на песчаной подушке
										с засыпкой.
										Ввод канализации 1 шт: выпускная канализационная труба с уклоном не менее 10
										мм/м на песчаной
										подушке с засыпкой
										Ввод эл-ва: труба ПНД 63 мм под ввод электричества, 10 м.п. на глубине не менее
										600 мм от
										поверхности грунта с сигнальной лентой
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обвязка фундамента антисептированным составным ростверком
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
						</ul>
					</div>
					<div class="equipment-tabs__content-image">
						<img src="./assets/img/acc.jpg" alt="img">
					</div>
				</div>
			</div>
			<div class="equipment-tabs__content" data-tab="naruzhka">
				<div class="equipment-tabs__content-inner">
					<div class="equipment-tabs__content-acc">
						<ul>
							<li>
								<dl>
									<dt>
										Выезд специалиста
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Привязка дома на участке
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Пробное бурение почвы
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Монтаж ж/б свай
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обустройство закладных
									</dt>
									<dd>
										Ввод воды 1 шт: гильза с уклоном не менее 10 мм/м на песчаной подушке
										с засыпкой.
										Ввод канализации 1 шт: выпускная канализационная труба с уклоном не менее 10
										мм/м на песчаной
										подушке с засыпкой
										Ввод эл-ва: труба ПНД 63 мм под ввод электричества, 10 м.п. на глубине не менее
										600 мм от
										поверхности грунта с сигнальной лентой
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обвязка фундамента антисептированным составным ростверком
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
						</ul>
					</div>
					<div class="equipment-tabs__content-image">
						<img src="./assets/img/acc.jpg" alt="img">
					</div>
				</div>
			</div>
			<div class="equipment-tabs__content" data-tab="window">
				<div class="equipment-tabs__content-inner">
					<div class="equipment-tabs__content-acc">
						<ul>
							<li>
								<dl>
									<dt>
										Выезд специалиста
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Привязка дома на участке
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Пробное бурение почвы
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Монтаж ж/б свай
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обустройство закладных
									</dt>
									<dd>
										Ввод воды 1 шт: гильза с уклоном не менее 10 мм/м на песчаной подушке
										с засыпкой.
										Ввод канализации 1 шт: выпускная канализационная труба с уклоном не менее 10
										мм/м на песчаной
										подушке с засыпкой
										Ввод эл-ва: труба ПНД 63 мм под ввод электричества, 10 м.п. на глубине не менее
										600 мм от
										поверхности грунта с сигнальной лентой
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обвязка фундамента антисептированным составным ростверком
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
						</ul>
					</div>
					<div class="equipment-tabs__content-image">
						<img src="./assets/img/acc.jpg" alt="img">
					</div>
				</div>
			</div>
			<div class="equipment-tabs__content" data-tab="more">
				<div class="equipment-tabs__content-inner">
					<div class="equipment-tabs__content-acc">
						<ul>
							<li>
								<dl>
									<dt>
										Выезд специалиста
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Привязка дома на участке
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Пробное бурение почвы
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Монтаж ж/б свай
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обустройство закладных
									</dt>
									<dd>
										Ввод воды 1 шт: гильза с уклоном не менее 10 мм/м на песчаной подушке
										с засыпкой.
										Ввод канализации 1 шт: выпускная канализационная труба с уклоном не менее 10
										мм/м на песчаной
										подушке с засыпкой
										Ввод эл-ва: труба ПНД 63 мм под ввод электричества, 10 м.п. на глубине не менее
										600 мм от
										поверхности грунта с сигнальной лентой
									</dd>
								</dl>
							</li>
							<li>
								<dl>
									<dt>
										Обвязка фундамента антисептированным составным ростверком
									</dt>
									<dd>
										На этом этапе мы определяем финальное расположение дома на участке. При работе
										мы учитываем
										требования плана застройки, топографические особенности, характер
										растительности, расположение
										дорог, улицы, а также природное окружение и солнечную инсоляцию.
									</dd>
								</dl>
							</li>
						</ul>
					</div>
					<div class="equipment-tabs__content-image">
						<img src="./assets/img/acc.jpg" alt="img">
					</div>
				</div>
			</div>
			<div class="eq-ancho-link"></div>
		</div>
	</div>
</section>
<section class="section examples">
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
				<div class="splide__slide examples-item projects-item">
					<div class="splide projects-slider__images">
						<div class="splide__track">
							<ul class="splide__list projects-slider__image-items">
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
							</ul>
						</div>
					</div>
					<div class="projects-item__body">
						<div class="projects-item__name">
							Классика
						</div>
						<div class="projects-item__description">
							Серпуховский р-н, п. Оболенск
						</div>
						<div class="projects-item__specs">
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Площадь
								</div>
								<div class="projects-item__spec-value">
									123 м<sup>2</sup>
								</div>
							</div>
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Размер
								</div>
								<div class="projects-item__spec-value">
									12х24 м
								</div>
							</div>
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Комнаты
								</div>
								<div class="projects-item__spec-value">
									4
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="splide__slide examples-item projects-item">
					<div class="splide projects-slider__images">
						<div class="splide__track">
							<ul class="splide__list projects-slider__image-items">
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
							</ul>
						</div>
					</div>
					<div class="projects-item__body">
						<div class="projects-item__name">
							Классика
						</div>
						<div class="projects-item__description">
							Серпуховский р-н, п. Оболенск
						</div>
						<div class="projects-item__specs">
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Площадь
								</div>
								<div class="projects-item__spec-value">
									123 м<sup>2</sup>
								</div>
							</div>
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Размер
								</div>
								<div class="projects-item__spec-value">
									12х24 м
								</div>
							</div>
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Комнаты
								</div>
								<div class="projects-item__spec-value">
									4
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="splide__slide examples-item projects-item">
					<div class="splide projects-slider__images">
						<div class="splide__track">
							<ul class="splide__list projects-slider__image-items">
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
								<li class="splide__slide projects-slider__image-item">
									<img src="./assets/img/pr1.jpg" alt="img">
								</li>
							</ul>
						</div>
					</div>
					<div class="projects-item__body">
						<div class="projects-item__name">
							Классика
						</div>
						<div class="projects-item__description">
							Серпуховский р-н, п. Оболенск
						</div>
						<div class="projects-item__specs">
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Площадь
								</div>
								<div class="projects-item__spec-value">
									123 м<sup>2</sup>
								</div>
							</div>
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Размер
								</div>
								<div class="projects-item__spec-value">
									12х24 м
								</div>
							</div>
							<div class="projects-item__spec">
								<div class="projects-item__spec-name">
									Комнаты
								</div>
								<div class="projects-item__spec-value">
									4
								</div>
							</div>
						</div>
					</div>
				</div>
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
<section class="section question-form">
	<div class="container">
		<div class="question-form__inner">
			<div class="section-title">
				Остались вопросы?
			</div>
			<div class="question-form__form-subtitle">
				Оставьте свои контакты — и мы с удовольствием ответим на все ваши вопросы и поможем с выбором идеального
				дома!
			</div>
			<form class="question-form__form">
				<div class="input-row">
					<div class="float-input">
						<input id="name" type="text" autocomplete="name" />
						<label for="name">Ваше имя</label>
					</div>
					<div class="float-input">
						<input type="tel" id="tel" name="tel" autocomplete="tel">
						<label for="tel">Номер телефона</label>
					</div>
					<div class="custom-select" data-placeholder="Удобное время">
						<div class="custom-select__trigger">
							<span class="custom-select__value"></span>
							<label>Удобное время</label>
							<span class="custom-select__arrow"></span>
						</div>
						<ul class="custom-select__options">
							<li data-value="1">с 12:00 до 20:00</li>
							<li data-value="2">с 12:00 до 20:02</li>
							<li data-value="3">с 12:00 до 20:03</li>
						</ul>
						<input type="hidden" name="my-select">
					</div>
				</div>
				<div class="agreed">
					<label class="custom-checkbox">
						<input type="checkbox" name="agree" />
						<span class="checkmark"></span>
						<span class="agreed-text">Я согласен на обработку персональных данных и ознакомлен с <a
								href="javascript:void(0)" target="_blank">политикой
								конфиденциальности</a></span>
					</label>
				</div>
				<button type="submit" class="arrow-btn__light">
					<span>
						Заказать звонок
					</span>
					<div class="icon">
						<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M11.9167 6L6.91667 11M1.5 6H11.9167H1.5ZM11.9167 6L6.91667 1L11.9167 6Z"
								stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</button>
			</form>
		</div>
	</div>
</section>
*/?>