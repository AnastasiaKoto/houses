<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |	Attention!
 * |	The following comments are for system use
 * |	and are required for the component to work correctly in ajax mode:
 * |	<!-- items-container -->
 * |	<!-- pagination-container -->
 * |	<!-- component-end -->
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');
?>
<pre>
	<? // print_r($arResult['MODIFIED_ITEMS']); ?>
</pre>

<? if (!empty($arResult['MODIFIED_ITEMS'])): ?>
	<section class="section projects">
		<div class="container">
			<div class="projects-inner">
				<div class="projects-head">
					<div class="section-title">
						Посмотрите на наши работы
					</div>
				</div>

			</div>
		</div>
		<div class="projects-tabs">
			<div class="container">
				<div class="projects-tabs__inner">
					<div class="projects-tabs__links">
						<a href="javascript:void(0)" class="projects-tabs__link active">
							<span>
								Реализованные проекты
							</span>
						</a>
						<a href="javascript:void(0)" class="projects-tabs__link">
							<span>
								Активные стройки
							</span>
							<div class="projects-tabs__link-live">
								<div class="projects-tabs__link-live-round"></div>
								<div class="projects-tabs__link-live-text">
									Live
								</div>
							</div>
						</a>
					</div>
					<div class="projects-arrows">
						<div class="projects-arrow projects-arrow__prev">
							<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11.4167 6H1H11.4167ZM1 6L6 1L1 6ZM1 6L6 11Z" fill="#8E9293" />
								<path d="M1 6L6 11M11.4167 6H1H11.4167ZM1 6L6 1L1 6Z" stroke="#8E9293" stroke-width="1.5"
									stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
						<div class="projects-arrow projects-arrow__next">
							<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6ZM11.4167 6L6.41667 11Z"
									fill="#8E9293" />
								<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z"
									stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
					</div>
				</div>
			</div>
			<div class="projects-tabs__content">
				<div class="projects-slider-wrapper">
					<div class="splide projects-slider">
						<div class="splide__track">
							<ul class="splide__list projects-items">
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="splide projects-slider__images">
										<div class="splide__track">
											<ul class="splide__list projects-slider__image-items">
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr2.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr2.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr2.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr2.jpg" alt="img">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="splide projects-slider__images">
										<div class="splide__track">
											<ul class="splide__list projects-slider__image-items">
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr3.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr3.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr3.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr3.jpg" alt="img">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="splide projects-slider__images">
										<div class="splide__track">
											<ul class="splide__list projects-slider__image-items">
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr4.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr4.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr4.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr4.jpg" alt="img">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="splide projects-slider__images">
										<div class="splide__track">
											<ul class="splide__list projects-slider__image-items">
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr5.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr5.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr5.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr5.jpg" alt="img">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="projects-item__last-image">
										<img src="./assets/img/pr6.png" alt="img">
									</div>
									<div class="project-item__last-text">
										Посмотреть все выполненные проекты
									</div>
									<a href="javascript:void(0)" class="arrow-btn__dark">
										<span>
											Смотреть
										</span>
										<div class="icon">
											<svg width="13" height="12" viewBox="0 0 13 12" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<path
													d="M11.9167 6L6.91667 11M1.5 6H11.9167H1.5ZM11.9167 6L6.91667 1L11.9167 6Z"
													stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
													stroke-linejoin="round" />
											</svg>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="projects-slider-wrapper">
					<div class="splide projects-slider">
						<div class="splide__track">
							<ul class="splide__list projects-items">
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="splide projects-slider__images">
										<div class="splide__track">
											<ul class="splide__list projects-slider__image-items">
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr2.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr2.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr2.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr2.jpg" alt="img">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="splide projects-slider__images">
										<div class="splide__track">
											<ul class="splide__list projects-slider__image-items">
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr3.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr3.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr3.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr3.jpg" alt="img">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="splide projects-slider__images">
										<div class="splide__track">
											<ul class="splide__list projects-slider__image-items">
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr4.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr4.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr4.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr4.jpg" alt="img">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="splide projects-slider__images">
										<div class="splide__track">
											<ul class="splide__list projects-slider__image-items">
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr5.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr5.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr5.jpg" alt="img">
												</li>
												<li class="splide__slide projects-slider__image-item">
													<img src="./assets/img/pr5.jpg" alt="img">
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
								</li>
								<li class="splide__slide projects-item" onclick="window.location='javascript:void(0)'">
									<div class="projects-item__last-image">
										<img src="./assets/img/pr6.png" alt="img">
									</div>
									<div class="project-item__last-text">
										Посмотреть все выполненные проекты
									</div>
									<a href="javascript:void(0)" class="arrow-btn__dark">
										<span>
											Смотреть
										</span>
										<div class="icon">
											<svg width="13" height="12" viewBox="0 0 13 12" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<path
													d="M11.9167 6L6.91667 11M1.5 6H11.9167H1.5ZM11.9167 6L6.91667 1L11.9167 6Z"
													stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
													stroke-linejoin="round" />
											</svg>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<? endif; ?>