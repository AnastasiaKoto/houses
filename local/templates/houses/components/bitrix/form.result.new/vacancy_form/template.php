<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/**
 * @var array $arResult
 */
//p($arResult);
?>
<section id="vacancy-form" class="section question-form vacancy-form">
	<div class="container">
		<?

		if ($arResult["isFormErrors"] == "Y") {
			?>
			<div class="question-form__inner thx-inner">
				<div class="section-title">
					В форме содержатся ошибки!
				</div>
				<div class="question-form__form-subtitle">
					<?= $arResult['FORM_ERRORS']; ?>
				</div>
				<a href="javascript:void(0)" onclick="window.location.reload();" class="question-form__form-close">
					Закрыть
				</a>
			</div>
		<? } elseif ($arResult["isFormNote"] == "Y") { ?>
			<div class="question-form__inner thx-inner">
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
		<? } elseif ($arResult["isFormNote"] != "Y") { ?>
			<div class="question-form__inner">
				<div class="section-title">
					<?= $arResult['arForm']['NAME']; ?>
				</div>
				<div class="question-form__form-subtitle">
					<?= $arResult['arForm']['DESCRIPTION']; ?>
				</div>
				<?= $arResult["FORM_HEADER"] ?>
				<div class="question-form__form">
					<div class="input-row">
						<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { ?>
							<? if ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] != "file" && $arQuestion["STRUCTURE"][0]["FIELD_TYPE"] != "checkbox") {

								if ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "text") {
									?>
									<div class="float-input">
										<?= recreateTextField($FIELD_SID, $arQuestion, 'text'); ?>
									</div>
								<? } elseif($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "email") { ?>
									<div class="float-input">
										<?= $arQuestion["HTML_CODE"]; ?>
										<label for="vacancy_email">Электронная почта</label>
									</div>
								<? } elseif ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "hidden") { ?>
										<?= recreateTextField($FIELD_SID, $arQuestion, 'hidden', $arParams['VACANCY']); ?>
								<? } ?>
							<? } ?>
						<? } ?>
					</div>
					<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { ?>
						<? if ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "file") { ?>
							<div class="file-upload" id="fileUpload">
								<?= $arQuestion["HTML_CODE"]; ?>

								<label for="fileInput" id="fileLabel">
									<div class="file-label-top">Формат файла – DOC, PDF</div>
									<div class="file-label-main">Выберите файл</div>
								</label>
							</div>
						<? } ?>
					<? } ?>
					<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
						if ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "checkbox") {
							?>
							<div class="agreed">
								<label class="custom-checkbox">
									<?= $arQuestion["HTML_CODE"]; ?>
									<span class="checkmark"></span>
									<span class="agreed-text"><?= $arQuestion['CAPTION']; ?></span>
								</label>
							</div>
						<? }
					} ?>
					<button type="submit" class="arrow-btn__light" name="web_form_submit"
						value="<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == "" ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>">
						<span>
							<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == "" ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>
						</span>
						<div class="icon">
							<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11.9167 6L6.91667 11M1.5 6H11.9167H1.5ZM11.9167 6L6.91667 1L11.9167 6Z"
									stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
					</button>
				</div>
				<?= $arResult["FORM_FOOTER"]; ?>
			</div>
		<? } ?>

	</div>
</section>