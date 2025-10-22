<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/**
 * @var array $arResult
 */

?>
<? if ($arResult["isFormNote"] == "Y") { ?>
	<div class="thx-inner">
		<div class="section-title">
		Ваша заявка успешно отправлена!
		</div>
		<div class="question-form__form-subtitle">
		Наш менеджер свяжется с вами по номеру:
		</div>
		<a href="+79999878797" class="question-form__form-phone">
		+7 (999) 987-87-97
		</a>
		<a href="javascript:void(0)" onclick="window.location.reload();" class="question-form__form-close">
		Закрыть
		</a>
	</div>
	<script>
		document.querySelector('.main_section-title').style.display = 'none';
		document.querySelector('.main_question-form__form-subtitle').style.display = 'none';
	</script>
<? } elseif ($arResult["isFormNote"] != "Y") { ?>
	<div class="contacts-form" data-move-target=".contacts-map__frame" data-move-break="992">
		<div class="contacts-form__title">
			<?= $arResult['arForm']['NAME']; ?>
		</div>
		<div class="contacts-form__description">
			<?= $arResult['arForm']['DESCRIPTION']; ?>
		</div>
		<?= $arResult["FORM_HEADER"] ?>
			<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { ?>
				<? if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] != "checkbox") { 
					
					if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "text") {
				?>
					<div class="float-input input-wrapper">
						<?= recreateTextField($FIELD_SID, $arQuestion, 'text'); ?>
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
			<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { 
				if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "checkbox") { 
			?>
			<label class="custom-checkbox-black input-wrapper">
				<?= recreateTextField($FIELD_SID, $arQuestion, $arQuestion["STRUCTURE"][0]["FIELD_TYPE"]); ?>
				<? // $arQuestion["HTML_CODE"]; ?>
				<span class="checkmark">
					<svg width="12" height="10" viewBox="0 0 12 10" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path d="M1.3335 5.66406L4.00016 8.33073L10.6668 1.66406" stroke="white"
							stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</span>
				<span class="checkbox-text"><?= $arQuestion['CAPTION']; ?></span>
			</label>
			<? } } ?>
			<button type="submit" class="arrow-btn__dark modal-submit" name="web_form_submit" value="<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == "" ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>">
				<span>
					<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == "" ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>
				</span>
				<div class="icon">
					<svg width="13" height="13" viewBox="0 0 13 13" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<path
							d="M11.4167 6.5L6.41667 11.5M1 6.5H11.4167H1ZM11.4167 6.5L6.41667 1.5L11.4167 6.5Z"
							stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
							stroke-linejoin="round" />
					</svg>
				</div>
			</button>
		<?= $arResult["FORM_FOOTER"]; ?>
	</div>
	<?if ($arResult["isFormErrors"] == "Y") { 
		$fields = [];
		foreach($arResult['FORM_ERRORS'] as $key => $value) {
			$fields[] = $key;
		}
		?>
		<script>
			const fields = <?= json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
			const form = document.querySelector('.contacts-form form[name="<?= $arResult['arForm']['SID']; ?>"]');
			if (Array.isArray(fields) && fields.length > 0) {
				fields.forEach(field => {
					console.log(field);
					form.querySelector(`#${field}`).closest('.input-wrapper').classList.add('error');
				});
			}
		</script>
	<? } ?>
<? } ?>