<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/**
 * @var array $arResult
 */

?>
<?

if ($arResult["isFormErrors"] == "Y") {
	?>
	<div class="question-form__inner thx-inner" id="form-error__<?= $arParams["WEB_FORM_ID"] ?>" style="display: none;">
		<div class="section-title">
		В форме содержатся ошибки!
		</div>
		<a href="javascript:void(0)" class="question-form__form-close">
		Закрыть
		</a>
	</div>
	<script>
		new Fancybox([{
			src: '#form-error__<?= $arParams["WEB_FORM_ID"] ?>',
			type: 'inline',
		}]);
	</script>
<? }

if ($arResult["isFormNote"] == "Y") { ?>
	<div class="question-form__inner thx-inner" id="form-success__<?= $arParams["WEB_FORM_ID"] ?>" style="display: none;">
		<div class="section-title">
		Ваша заявка успешно отправлена!
		</div>
		<div class="question-form__form-subtitle">
		Наш менеджер свяжется с вами по номеру:
		</div>
		<a href="+79999878797" class="question-form__form-phone">
		+7 (999) 987-87-97
		</a>
		<a href="javascript:void(0)" class="question-form__form-close">
		Закрыть
		</a>
	</div>
	<script>
		new Fancybox([{
			src: '#form-success__<?= $arParams["WEB_FORM_ID"] ?>',
			type: 'inline',
		}],
			{
				on: {
					destroy: (fancybox, eventName) => {
						window.location.reload();
					},
				},
			});
	</script>
<? } ?>
<?= $arResult["FORM_NOTE"];

if ($arResult["isFormNote"] != "Y") { ?>
	<?= $arResult["FORM_HEADER"] ?>
	<div class="question-form__form">
		<div class="input-row">
			<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { ?>
				<? if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] != "checkbox") { 
					
					if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "text") {
				?>
					<div class="float-input">
						<input id="<?= $FIELD_SID; ?>" name="<?= $FIELD_SID; ?>" type="text" autocomplete="name" />
						<label for="<?= $FIELD_SID; ?>"><?= $arQuestion['CAPTION']; ?></label>
					</div>
					<? } elseif($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "hidden") { ?>
					<div class="custom-select" data-placeholder="<?= $arQuestion['CAPTION']; ?>">
						<div class="custom-select__trigger">
							<span class="custom-select__value"></span>
							<label><?= $arQuestion['CAPTION']; ?></label>
							<span class="custom-select__arrow"></span>
						</div>
						<? if(is_array($arQuestion["STRUCTURE"])) { 
							$count = 1;
						?>
						<ul class="custom-select__options">
							<? foreach($arQuestion["STRUCTURE"] as $item) { ?>
							<li data-value="<?= $count; ?>"><?= $item['MESSAGE']; ?></li>
							<? } ?>
						</ul>
						<? $count++; } ?>
						<input type="hidden" name="<?= $FIELD_SID; ?>">
					</div>
					<? } ?>
			<? } ?>
			<? } ?>
		</div>
		<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { 
			if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "checkbox") { 
		?>
		<div class="agreed">
			<label class="custom-checkbox">
				<input type="checkbox" name="<?= $FIELD_SID; ?>" />
				<span class="checkmark"></span>
				<span class="agreed-text"><?= $arQuestion['CAPTION']; ?></span>
			</label>
		</div>
		<? } } ?>
		<button type="submit" class="arrow-btn__light" name="web_form_submit">
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
<? }