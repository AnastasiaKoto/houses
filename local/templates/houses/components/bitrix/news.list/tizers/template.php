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
	<section class="section why-we">
		<div class="container">
			<div class="why-we__inner">
				<div class="section-title">
					<? $APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						array(
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "",
							"EDIT_TEMPLATE" => "standard.php",
							"PATH" => "/include/mainpage/tizers/section_title.php"
						)
					); ?>
				</div>
				<div class="section-subtitle">
					<? $APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						array(
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "",
							"EDIT_TEMPLATE" => "standard.php",
							"PATH" => "/include/mainpage/tizers/section_descr.php"
						)
					); ?>
				</div>
				<div class="why-we__items">
					<? foreach ($arResult['ITEMS'] as $arItem): ?>
						<div class="why-we__item <?= $arItem['PROPERTIES']['DARK_TXT']['VALUE'] == 'Да' ? 'dark-text' : ''; ?>" <? if($arItem['PROPERTIES']['BTN_LINK']['VALUE'] && $arItem['PROPERTIES']['BTN_LINK']['VALUE'] !== '') {  ?> onclick="window.location='<?= $arItem['PROPERTIES']['BTN_LINK']['VALUE']; ?>'" <? } ?>>
							<div class="why-we__item-image">
								<? if ($arItem['PROPERTIES']['DARK_TXT']['VALUE'] !== 'Да') : ?>
									<div class="why-we__item-image__layer"></div>
								<? endif; ?>
								<?php if (!empty($arItem['DETAIL_PICTURE']['SRC'])) { ?>
									<picture>
										<source
											media="(max-width: 767px)"
											srcset="<?= $arItem['DETAIL_PICTURE']['SRC']; ?>">
										<source
											media="(min-width: 768px)"
											srcset="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>">
										<img
											src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>"
											alt="<?= $arItem['NAME']; ?>">
									</picture>
								<?php } else { ?>
									<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arItem['NAME']; ?>">
								<?php } ?>
							</div>
							<div class="why-we__item-title">
								<?= $arItem['NAME']; ?>
							</div>
							<div class="why-we__item-subtitle">
								<?= $arItem['~PREVIEW_TEXT']; ?>
							</div>
							<? if (!empty($arItem['PROPERTIES']['BTN_TXT']['VALUE'])): ?>
								<? $link = str_starts_with($arItem['PROPERTIES']['BTN_LINK']['VALUE'], '#') ? 'data-modal-target="' . $arItem['PROPERTIES']['BTN_LINK']['VALUE'] . '"' : 'href="' . $arItem['PROPERTIES']['BTN_LINK']['VALUE'] . '"'; ?>
								<a <?= $link; ?> class="simple-link why-we__item-link">
									<span>
										<?= $arItem['PROPERTIES']['BTN_TXT']['VALUE']; ?>
									</span>
									<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path
											d="M12.5003 8.5L8.50033 12.5M4.16699 8.5H12.5003H4.16699ZM12.5003 8.5L8.50033 4.5L12.5003 8.5Z"
											stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									</svg>
								</a>
							<? endif; ?>
						</div>
					<? endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<? endif; ?>