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
if(!empty($arResult['SECTIONS'])):
	//p($arParams['CURSECTION']);
?>
<div class="section-cats__links">
	<a href="/company/vacancies/" class="section-cats__link <?= $arResult['SECTION']['ID'] == 0 && !$arParams['CURSECTION'] ? 'current' : ''; ?>">
		Все
	</a>
	<? foreach($arResult['SECTIONS'] as $arSection): ?>
	<a href="<?= $arSection['SECTION_PAGE_URL']; ?>" class="section-cats__link <?= $arParams['CURSECTION'] == $arSection['ID'] ? 'current' : ''; ?>">
		<?= $arSection['NAME']; ?>
	</a>
	<? endforeach; ?>
</div>
<? endif; ?>