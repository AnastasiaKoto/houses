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
//p($arResult);
?>
<form class="smartfilter" name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<a href="javascript:void(0)" class="catalog-filters__mobile-trigger">
		<span class="btn-name">
			Фильтры
		</span>
		<span class="btn-count">
			3 фильтра включены
		</span>
	</a>
	<div class="catalog-sort">
		<div class="custom-select-cornored " data-placeholder="Удобное время">
			<div class="custom-select__trigger">
			<span class="custom-select__value"></span>
			<label>Сортировка</label>
			<span class="custom-select__arrow"></span>
			</div>
			<ul class="custom-select__options">
			<li data-value="1">По возрастанию цены</li>
			<li data-value="2">По убыванию цены</li>
			<li data-value="3">По алфавиту</li>
			</ul>
			<input type="hidden" name="my-select">
		</div>
	</div>
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
		<div class="catalog-filters__form">
			<?foreach($arResult["HIDDEN"] as $arItem):?>
				<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
				<?endforeach;?>
			<div class="catalog-filters__acc">
				<?foreach($arResult["ITEMS"] as $key=>$arItem) { 
					
					if ($key === 'SORT') continue;

					if($arItem['CODE'] === 'HOUSES_PRICES' || $arItem['CODE'] === 'HOUSES_SQUARES'): 
						if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
							continue;
						$price_ranges = array();
						$step_num = $arItem['CODE'] === 'HOUSES_PRICES' ? 3 : 4;
						$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
						$ch_name = $arItem['CODE'] === 'HOUSES_PRICES' ? 'price_ranges[]' : 'square_ranges[]';

						for ($i = 0; $i < $step_num; $i++) {
							$range_min = $arItem["VALUES"]["MIN"]["VALUE"] + $step * $i;
							$range_max = $arItem["VALUES"]["MIN"]["VALUE"] + $step * ($i + 1);
							$precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
							//уменьшаем, чтобы диапазоны не пересекались
							if ($i < $step_num - 1) {
								$range_max -= 0.01;
							}
							// Создаем названия для чекбоксов
							if($arItem['CODE'] === 'HOUSES_PRICES') {
								if ($i == 0) {
									$range_name = "до " . formatPriceInMillions($range_max) . ' ₽';
								} elseif ($i == $step_num - 1) {
									$range_name = "от " . formatPriceInMillions($range_min) . ' ₽';
								} else {
									$range_name = formatPriceInMillions($range_min) . " ₽ - " . formatPriceInMillions($range_max) . ' ₽';
								}
							} else {
								//тут увеличиваем чтобы вернуть отображение
								if ($i == 0) {
									$range_name = "до " . $range_max + 0.01 . ' м<sup>2</sup>';
								} elseif ($i == $step_num - 1) {
									$range_name = "от " . $range_min +0.01 . ' м<sup>2</sup>';
								} else {
									$range_name = $range_min . " м<sup>2</sup> - " . $range_max . ' м<sup>2</sup>';
								}
							}
							
							$price_ranges[] = array(
								'min' => $range_min,
								'max' => $range_max,
								'name' => $range_name,
								'control_name' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"] . "_range_" . $i,
								'control_id' => $arItem["VALUES"]["MIN"]["CONTROL_ID"] . "_range_" . $i
							);
						}
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
								<span>
									<?=$arItem["NAME"]?>
								</span>
								<svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1 1.5L5 5.5L9 1.5" stroke="#21272A" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
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
										onchange=""
										data-min="<?=$range['min']?>"
										data-max="<?=$range['max']?>"
									>
									<span class="checkmark">
										<svg width="12" height="10" viewBox="0 0 12 10" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path d="M1.3335 5.66406L4.00016 8.33073L10.6668 1.66406" stroke="white" stroke-width="1.5"
											stroke-linecap="round" stroke-linejoin="round" />
										</svg>
									</span>
									<span class="checkbox-text"><?=$range['name']?></span>
								</label>
								<?endforeach;?>
							</div>
						</div>
						<script>
							BX.ready(function(){
								window.initRanges = function() {
									var minInput = document.getElementById('<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>');
									var maxInput = document.getElementById('<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>');
									var checkboxes = document.querySelectorAll('input[name="<?= $ch_name; ?>"]');

									if (minInput.value && maxInput.value) {
										var currentMin = parseFloat(minInput.value);
										var currentMax = parseFloat(maxInput.value);
										
										checkboxes.forEach(function(checkbox) {
											var min = parseFloat(checkbox.getAttribute('data-min'));
											var max = parseFloat(checkbox.getAttribute('data-max'));
											
											// Отмечаем чекбоксы, которые попадают в текущий диапазон
											if ((min >= currentMin && min <= currentMax) || 
												(max >= currentMin && max <= currentMax) ||
												(currentMin >= min && currentMax <= max)) {
												checkbox.checked = true;
											}
										});
									}
								};
								
								initRanges();

								function initRangeCheckboxes() {
									var priceCheckboxes = document.querySelectorAll('input[name="<?= $ch_name; ?>"]');
									
									priceCheckboxes.forEach(function(checkbox) {
										checkbox.addEventListener('change', function() {
											// Находим базовый ID контрола (убираем _range_X)
											var baseControlId = this.id.replace(/_range_\d+$/, '');
											
											var minInput = document.getElementById('<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>');
											var maxInput = document.getElementById('<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>');
											
											if (!minInput || !maxInput) return;
											
											// Собираем все выбранные диапазоны для этого поля цены
											var rangeCheckboxes = document.querySelectorAll('input[name="<?= $ch_name; ?>"]');
											var selectedRanges = [];
											
											rangeCheckboxes.forEach(function(cb) {
												if (cb.checked) {
													selectedRanges.push({
														min: parseFloat(cb.getAttribute('data-min')),
														max: parseFloat(cb.getAttribute('data-max'))
													});
												}
											});
											
											// Вычисляем общий диапазон
											if (selectedRanges.length > 0) {
												var overallMin = Math.min.apply(Math, selectedRanges.map(function(range) { return range.min; }));
												var overallMax = Math.max.apply(Math, selectedRanges.map(function(range) { return range.max; }));
												
												minInput.value = overallMin;
												maxInput.value = overallMax;
											} else {
												// Если ничего не выбрано - очищаем поля
												minInput.value = '';
												maxInput.value = '';
											}
											if (window.smartFilter) {
												smartFilter.keyup(minInput);
											}
										});
									});
								}

								initRangeCheckboxes();
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
		</div>
	</div>
</form>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>