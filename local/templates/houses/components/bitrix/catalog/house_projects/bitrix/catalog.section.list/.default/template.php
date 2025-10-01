<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<? if(!empty($arResult['SECTIONS'])): ?>
<div class="projects-tabs__links">
	<? foreach($arResult['SECTIONS'] as $arItem): ?>
		<a href="<?= $arItem['SECTION_PAGE_URL']; ?>" class="projects-tabs__link <? if($arParams['CURRENT_SECTION'] == $arItem['ID']) { echo 'active';} ?>">
			<span>
				<?= $arItem['NAME']; ?>
			</span>
			<? if($arItem['NAME'] == 'Активные' || $arItem['NAME'] == 'Активные проекты') { ?>
				<div class="projects-tabs__link-live">
					<div class="projects-tabs__link-live-round"></div>
					<div class="projects-tabs__link-live-text">
					Live
					</div>
				</div>
			<? } ?>
		</a>
	<? endforeach; ?>
</div>
<? endif; ?>