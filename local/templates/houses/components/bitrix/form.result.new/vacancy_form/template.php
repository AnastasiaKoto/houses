<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/**
 * @var array $arResult
 */
//p($arResult);
?>

<div class="container">
	<? if ($arResult["isFormNote"] == "Y") { ?>
		<? 
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
		<div class="question-form__inner thx-inner">
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
								<div class="float-input input-wrapper">
									<?= recreateTextField($FIELD_SID, $arQuestion, 'text'); ?>
								</div>
							<? } elseif ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "email") { ?>
								<div class="float-input input-wrapper">
									<? // $arQuestion["HTML_CODE"]; ?>
									<?= recreateTextField($FIELD_SID, $arQuestion, $arQuestion["STRUCTURE"][0]["FIELD_TYPE"]); ?>
								</div>
							<? } elseif ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "hidden") { ?>
								<?= recreateTextField($FIELD_SID, $arQuestion, 'hidden', '', $arParams['VACANCY']); ?>
							<? } ?>
						<? } ?>
					<? } ?>
				</div>
				<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { ?>
					<? if ($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "file") { ?>
						<div class="file-upload  input-wrapper" id="fileUpload">
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
							<label class="custom-checkbox input-wrapper">
								<?= recreateTextField($FIELD_SID, $arQuestion, $arQuestion["STRUCTURE"][0]["FIELD_TYPE"]); ?>
								<? //$arQuestion["HTML_CODE"]; ?>
								<span class="checkmark"></span>
								<span class="agreed-text"><?= $arQuestion['~CAPTION']; ?></span>
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
							<path d="M11.9167 6L6.91667 11M1.5 6H11.9167H1.5ZM11.9167 6L6.91667 1L11.9167 6Z" stroke="white"
								stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</button>
			</div>
			<?= $arResult["FORM_FOOTER"]; ?>
		</div>
		<?
		if ($arResult["isFormErrors"] == "Y") {
			$fields = [];
			foreach ($arResult['FORM_ERRORS'] as $key => $value) {
				$fields[] = $key;
			}
			?>
			<script>
				(() => {
					const fields = <?= json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
					console.log(fields);
					const form = document.querySelector('.question-form__inner form[name="<?= $arResult['arForm']['SID']; ?>"]');
					if (Array.isArray(fields) && fields.length > 0) {
						fields.forEach(field => {
							let parent = form.querySelector(`#${field}`).closest('.input-wrapper');
							if(!parent.classList.contains('error')) {
								parent.classList.add('error');
							}
						});
					}
				})();
			</script>
		<? } ?>
	<? } ?>

</div>