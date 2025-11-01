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
?>
<div class="compare-tabs">
	<ul class="compare-tabs__links">
		<? 
		$counter = 1;
		foreach($arResult['ITEMS'] as $arItem): ?>
		<li>
			<button class="compare-tabs__link <?= $counter == 1 ? 'active' : ''; ?>" data-tab="<?= $arItem['ID']; ?>">
				<?= $arItem['NAME']; ?>
			</button>
		</li>
		<? $counter++; endforeach; ?>
	</ul>

	<? 
	$counter = 1;
	foreach($arResult['ITEMS'] as $arItem): ?>
	<div class="compare-tabs__content <?= $counter == 1 ? 'active' : ''; ?>" data-tab-content="<?= $arItem['ID']; ?>">
		<div class="compare-tabs__images">
			<? if(!empty($arItem['DISPLAY_PROPERTIES']['PICTURES']['FILE_VALUE'])): ?>
				<? foreach($arItem['DISPLAY_PROPERTIES']['PICTURES']['FILE_VALUE'] as $img): ?>
					<div class="compare-tabs__image">
						<img src="<?= $img['SRC']; ?>" alt="img">
					</div>
				<? endforeach; ?>
			<? endif; ?>
		</div>
	</div>
	<? $counter++; endforeach; ?>
</div>
<? endif; ?>