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
	$count = 1;
?>
<section class="section questions">
	<div class="container">
		<div class="questions-inner">
			<div class="section-title">
				<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
						"AREA_FILE_SHOW" => "file", 
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/mainpage/faq/section_title.php" 
					)
				);?>
			</div>
			<div class="questions-acc">
				<? foreach($arResult['ITEMS'] as $arItem): ?>
				<div class="question-acc__item">
					<div class="questions-acc__title">
						<div class="questions-acc__title-num">
							<?= $count; ?>
						</div>
						<div class="questions-acc__title-text">
							<?= $arItem['NAME']; ?>
						</div>
						<div class="questions-acc__title-icon">
							<svg width="13" height="13" viewBox="0 0 13 13" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M6.70801 12.0026L11.708 7.0026M6.70801 1.58594V12.0026V1.58594ZM6.70801 12.0026L1.70801 7.0026L6.70801 12.0026Z"
									stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
					</div>
					<div class="question-acc__content">
						<?= $arItem['~PREVIEW_TEXT']; ?>
					</div>
				</div>
				<? $count++; endforeach; ?>
			</div>
			<a href="#question" class="ask-btn">Задать свой вопрос</a>
		</div>
	</div>
</section>
<? endif; ?>