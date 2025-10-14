<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */


if (!empty($arResult['ERROR'])) {
	echo $arResult['ERROR'];
	return false;
}
if(!empty($arResult['rows'])):
?>
<section class="section certificates">
	<div class="container">
		<div class="section-title">
			<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
					"AREA_FILE_SHOW" => "file", 
					"AREA_FILE_SUFFIX" => "",
					"EDIT_TEMPLATE" => "standard.php",
					"PATH" => "/include/docs/serts-title.php" 
				)
			); ?>
		</div>
		<div class="documents-description">
			<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
					"AREA_FILE_SHOW" => "file", 
					"AREA_FILE_SUFFIX" => "",
					"EDIT_TEMPLATE" => "standard.php",
					"PATH" => "/include/docs/serts-descr.php" 
				)
			); ?>
		</div>
		<div class="splide certificates-slider">
			<div class="splide__track">
				<ul class="splide__list certificates-items">
					<? foreach($arResult['rows'] as $row): ?>
					<li class="splide__slide certificates-item">
						<div class="certificates-item__image">
							<?= $row['UF_IMG']; ?>
						</div>
						<div class="certificates-item__body">
							<div class="certificates-item__name">
								<?= $row['UF_TITLE']; ?>
							</div>
							<div class="certificates-item__description">
								<?= $row['UF_DESCR']; ?>
							</div>
							<a href="<?= $row['UF_PDF']; ?>" target="_blank" class="documents-item__link">
								<span>
									Посмотреть PDF
								</span>
								<svg width="11" height="11" viewBox="0 0 11 11" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M9.33333 5.5L5.33333 9.5M1 5.5H9.33333H1ZM9.33333 5.5L5.33333 1.5L9.33333 5.5Z"
										stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
										stroke-linejoin="round" />
								</svg>
							</a>
						</div>
					</li>
					<? endforeach; ?>
				</ul>
			</div>
			<div class="certs-arrows">
				<div class="slider-arrow certs-arrow certs-arrow__prev">
					<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.4167 6H1H11.4167ZM1 6L6 1L1 6ZM1 6L6 11Z" fill="#8E9293" />
						<path d="M1 6L6 11M11.4167 6H1H11.4167ZM1 6L6 1L1 6Z" stroke="#8E9293" stroke-width="1.5"
							stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
				<div class="slider-arrow certs-arrow certs-arrow__next">
					<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6ZM11.4167 6L6.41667 11Z" fill="#8E9293" />
						<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="#8E9293"
							stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
			</div>
		</div>
	</div>
</section>
<? endif; ?>