<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/**
 * @var array $arResult
 */

?>
<?
$prefix = '_' . $arParams['UNIQUE_PREFIX'] ?? ''; ?>
<? if ($arResult["isFormNote"] == "Y") { 
	if(isset($_REQUEST['RESULT_ID'])) {
		$resultId = intval($_REQUEST['RESULT_ID']);
		$fieldId = 0;
		foreach($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
			if($FIELD_SID == 'PHONE') {
				$fieldId = $arQuestion['STRUCTURE'][0]['ID'];
				break;
			}
		}
		$userPhone = getUserPhone($resultId, $fieldId);
	}
?>
	<div class="thx-inner">
		<div class="section-title">
		Ваша заявка успешно отправлена!
		</div>
		<? if (isset($userPhone) && !empty($userPhone)): ?>
			<div class="question-form__form-subtitle">
			Наш менеджер свяжется с вами по номеру:
			</div>
		
            <span class="question-form__form-phone">
                <?= htmlspecialcharsbx($userPhone) ?>
			</span>
		<? endif; ?>
		<a href="javascript:void(0)" onclick="window.location.reload();" class="question-form__form-close">
		Закрыть
		</a>
	</div>
	<script>
		document.querySelector('.main_section-title').style.display = 'none';
		document.querySelector('.main_question-form__form-subtitle').style.display = 'none';
	</script>
<? } elseif ($arResult["isFormNote"] != "Y") { ?>
	<?= $arResult["FORM_HEADER"] ?>
	<div class="question-form__form">
		<div class="input-row">
			<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { 
			?>
				<? if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] != "checkbox") { 
					
					if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "text") {
				?>
					<div class="float-input input-wrapper">
						<?= recreateTextField($FIELD_SID, $arQuestion, 'text', $prefix); ?>
					</div>
					<? } elseif($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "hidden") { ?>
					<div class="custom-select input-wrapper" data-placeholder="<?= $arQuestion['CAPTION']; ?>">
						<div class="custom-select__trigger">
							<span class="custom-select__value"></span>
							<label><?= $arQuestion['CAPTION']; ?></label>
							<span class="custom-select__arrow"></span>
						</div>
						<ul class="custom-select__options">
							<li data-value="как можно скорее">как можно скорее</li>
							<li data-value="с 9:00 до 10:00">с 9:00 до 10:00</li>
							<li data-value="с 10:00 до 11:00">с 10:00 до 11:00</li>
							<li data-value="с 11:00 до 12:00">с 11:00 до 12:00</li>
							<li data-value="с 12:00 до 13:00">с 12:00 до 13:00</li>
							<li data-value="с 13:00 до 14:00">с 13:00 до 14:00</li>
							<li data-value="с 14:00 до 15:00">с 14:00 до 15:00</li>
							<li data-value="с 15:00 до 16:00">с 15:00 до 16:00</li>
							<li data-value="с 16:00 до 17:00">с 16:00 до 17:00</li>
							<li data-value="с 17:00 до 18:00">с 17:00 до 18:00</li>
							<li data-value="с 18:00 до 19:00">с 18:00 до 19:00</li>
							<li data-value="с 19:00 до 20:00">с 19:00 до 20:00</li>
						</ul>
						<?= $arQuestion["HTML_CODE"]; ?>
					</div>
					<? } ?>
			<? } ?>
			<? } ?>
		</div>
		<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { 
			if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "checkbox") { 
		?>
		<div class="agreed">
			<label class="custom-checkbox input-wrapper">
				<?= recreateTextField($FIELD_SID, $arQuestion, $arQuestion["STRUCTURE"][0]["FIELD_TYPE"], $prefix); ?>
				<? //$arQuestion["HTML_CODE"]; ?>
				<span class="checkmark"></span>
				<span class="agreed-text"><?= $arQuestion['CAPTION']; ?></span>
			</label>
		</div>
		<? } } ?>
		<button type="submit" class="arrow-btn__light" name="web_form_submit" value="<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == "" ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>">
			<span>
				<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == "" ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>
			</span>
			<div class="icon">
				<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.9167 6L6.91667 11M1.5 6H11.9167H1.5ZM11.9167 6L6.91667 1L11.9167 6Z" stroke="white"
						stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</div>
		</button>
	</div>
	<?= $arResult["FORM_FOOTER"]; ?>
	<?
	if ($arResult["isFormErrors"] == "Y") {
		$fields = [];
		foreach($arResult['FORM_ERRORS'] as $key => $value) {
			$fields[] = $key;
		}
		?>
		<script>
			const fields = <?= json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
			const form = document.querySelector('.question-form__inner form[name="<?= $arResult['arForm']['SID']; ?>"]');
			if (Array.isArray(fields) && fields.length > 0) {
				fields.forEach(field => {
					field =  field + '<?=$prefix?>';
					console.log(field);
					form.querySelector(`#${field}`).closest('.input-wrapper').classList.add('error');
				});
			}
		</script>
	<? } ?>
<? } ?>