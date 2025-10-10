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

use Bitrix\Iblock\SectionPropertyTable;

$this->setFrameMode(true);

$templateData = array(
'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
$this->addExternalCss($templateData['TEMPLATE_THEME']);
}
if(!empty($arResult["ITEMS"])):
?>
<div class="catalog-filters__inner">
	<div class="mobile-drag__line">
	<div class="mobile-drag__line-inner"></div>
	</div>
	<div class="catalog-filters__title">
	<span>
		Фильтры <span class="count-filters">(3)</span>
	</span>
	<a href="<?= $arResult['JS_FILTER_PARAMS']['SEF_DEL_FILTER_URL']; ?>" class="reset-filters__mobile">
		Сбросить все
	</a>
	</div>
	<form class="catalog-filters__form smartfilter" name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
		<?foreach($arResult["HIDDEN"] as $arItem):?>
			<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
		<?endforeach;?>
		<div class="catalog-filters__acc">
			<?foreach($arResult["ITEMS"] as $key=>$arItem) { 
				if ($key === 'SORT') continue;
				if($arItem['CODE'] === 'HOUSES_PRICES' || $arItem['CODE'] === 'HOUSES_SQUARES'):
					if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) continue;

					$price_ranges = [];

					if ($arItem['CODE'] === 'HOUSES_PRICES') {
						// Фиксированные диапазоны для цены
						$price_ranges = [
							[
								'min' => 0,
								'max' => 10000000,
								'name' => 'до 10 млн ₽',
								'control_name_suffix' => '_range_0',
								'control_id_suffix' => '_range_0'
							],
							[
								'min' => 10000000.01,
								'max' => 15000000,
								'name' => '10 - 15 млн ₽',
								'control_name_suffix' => '_range_1',
								'control_id_suffix' => '_range_1'
							],
							[
								'min' => 15000000.01,
								'max' => 999999999,
								'name' => 'от 15 млн ₽',
								'control_name_suffix' => '_range_2',
								'control_id_suffix' => '_range_2'
							]
						];
						$ch_name = 'price_ranges[]';
					} else {
						// Фиксированные диапазоны для площади
						$price_ranges = [
							[
								'min' => 0,
								'max' => 100,
								'name' => 'до 100 м<sup>2</sup>',
								'control_name_suffix' => '_range_0',
								'control_id_suffix' => '_range_0'
							],
							[
								'min' => 100.01,
								'max' => 150,
								'name' => '100 - 150 м<sup>2</sup>',
								'control_name_suffix' => '_range_1',
								'control_id_suffix' => '_range_1'
							],
							[
								'min' => 150.01,
								'max' => 99999,
								'name' => 'от 150 м<sup>2</sup>',
								'control_name_suffix' => '_range_2',
								'control_id_suffix' => '_range_2'
							]
						];
						$ch_name = 'square_ranges[]';
					}

					foreach ($price_ranges as &$range) {
						$range['control_name'] = $arItem["VALUES"]["MIN"]["CONTROL_NAME"] . $range['control_name_suffix'];
						$range['control_id'] = $arItem["VALUES"]["MIN"]["CONTROL_ID"] . $range['control_id_suffix'];
					}
					unset($range);
					?>

					<div class="ctalog-filters__acc-item <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>open<? endif; ?>">
						<input
							type="hidden"
							name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
							id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
							value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
							onkeyup="smartFilter.keyup(this)"
						/>
						<input
							type="hidden"
							name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
							id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
							value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
							onkeyup="smartFilter.keyup(this)"
						/>
						<div class="catalog-filter__acc-title <?if (isset($arItem["DISPLAY_EXPANDED"]) && $arItem["DISPLAY_EXPANDED"] == "Y"):?>open<?endif?>">
							<span><?=$arItem["NAME"]?></span>
							<svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1 1.5L5 5.5L9 1.5" stroke="#21272A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
						<div class="catalog-filter__acc-content">
							<?foreach($price_ranges as $range):?>
							<label class="custom-checkbox-black">
								<input 
									type="checkbox" 
									name="<?= $ch_name; ?>" 
									id="<?=$range['control_id']?>"
									value="<?=$range['min']?>-<?=$range['max']?>"
									data-min="<?=$range['min']?>"
									data-max="<?=$range['max']?>"
								>
								<span class="checkmark">
									<svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.3335 5.66406L4.00016 8.33073L10.6668 1.66406" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									</svg>
								</span>
								<span class="checkbox-text"><?=$range['name']?></span>
							</label>
							<?endforeach;?>
						</div>
					</div>

					<script>
						BX.ready(function(){
							function initFixedRanges() {
								var minInput = document.getElementById('<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>');
								var maxInput = document.getElementById('<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>');
								var checkboxes = document.querySelectorAll('input[name="<?= $ch_name; ?>"]');

								// Восстановление состояния чекбоксов при загрузке
								if (minInput.value !== '' && maxInput.value !== '') {
									var currentMin = parseFloat(minInput.value);
									var currentMax = parseFloat(maxInput.value);

									checkboxes.forEach(function(checkbox) {
										var min = parseFloat(checkbox.getAttribute('data-min'));
										var max = parseFloat(checkbox.getAttribute('data-max'));

										// Проверяем пересечение диапазонов
										if (currentMin <= max && currentMax >= min) {
											checkbox.checked = true;
										}
									});
								}

								// Обработчик изменений
								checkboxes.forEach(function(checkbox) {
									checkbox.addEventListener('change', function() {
										var selectedRanges = [];
										document.querySelectorAll('input[name="<?= $ch_name; ?>"]').forEach(function(cb) {
											if (cb.checked) {
												selectedRanges.push({
													min: parseFloat(cb.getAttribute('data-min')),
													max: parseFloat(cb.getAttribute('data-max'))
												});
											}
										});

										if (selectedRanges.length > 0) {
											var overallMin = Math.min.apply(Math, selectedRanges.map(r => r.min));
											var overallMax = Math.max.apply(Math, selectedRanges.map(r => r.max));
											minInput.value = overallMin;
											maxInput.value = overallMax;
										} else {
											minInput.value = '';
											maxInput.value = '';
										}

										if (window.smartFilter) {
											smartFilter.keyup(minInput);
										}
									});
								});
							}

							initFixedRanges();
						});
					</script>
				<? else: ?>
					<div class="ctalog-filters__acc-item <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>open<? endif; ?>">
						<div class="catalog-filter__acc-title">
							<span>
								<?= $arItem['NAME']; ?>
							</span>
							<svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1.5L5 5.5L9 1.5" stroke="#21272A" stroke-width="1.5" stroke-linecap="round"
								stroke-linejoin="round" />
							</svg>
						</div>
						<div class="catalog-filter__acc-content">
							<?foreach($arItem["VALUES"] as $val => $ar):?>
							<label class="custom-checkbox-black <? echo $ar["DISABLED"] ? 'disabled': '' ?>">
								<input
									type="checkbox"
									value="<? echo $ar["HTML_VALUE"] ?>"
									name="<? echo $ar["CONTROL_NAME"] ?>"
									id="<? echo $ar["CONTROL_ID"] ?>"
									<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
									onclick="smartFilter.click(this)"
								/>
								<span class="checkmark">
									<svg width="12" height="10" viewBox="0 0 12 10" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path d="M1.3335 5.66406L4.00016 8.33073L10.6668 1.66406" stroke="white" stroke-width="1.5"
										stroke-linecap="round" stroke-linejoin="round" />
									</svg>
								</span>
								<span class="checkbox-text"><?=$ar["VALUE"];?></span>
							</label>
							<?endforeach;?>
						</div>
					</div>
				<? endif; ?>
			<? } ?>
		</div>
		<button type="button" class="reset-filters" type="submit" id="del_filter" name="del_filter">
			Сбросить фильтры
		</button>
		<button type="button" class="arrow-btn__dark apply-filters" type="submit" id="set_filter" name="set_filter">
			<span>
			Применить выбранные фильтры
			</span>
			<div class="icon">
			<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="#2E2F33"
				stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			</div>
		</button>
		<div id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: none;">
			<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.(int)($arResult["ELEMENT_COUNT"] ?? 0).'</span>'));?>
			<span class="arrow"></span>
			<br/>
			<a href="<?echo $arResult["FILTER_URL"]?>" target=""><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
		</div>
		<div class="clb"></div>
	</form>
</div>
<? endif; ?>
<script>
var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>