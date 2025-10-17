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
	<div class="modal-content thx-content">
          <div class="modal-title">
            В форме содержатся ошибки!
          </div>
          <a href="tel:+79999879898" target="_blank" class="modal-thx__phone">
            +7 (999) 987-98-98
          </a>
          <button class="modal-close" onclick="window.location.reload();">
          Закрыть окно
        </button>
    </div>
<? } elseif ($arResult["isFormNote"] == "Y") { ?>
	<div class="modal-content thx-content">
          <div class="modal-title">
            Ваша заявка успешно отправлена!
          </div>
          <div class="modal-subtitle">
           Наш менеджер свяжется с вами по номеру:
          </div>
          <a href="tel:+79999879898" target="_blank" class="modal-thx__phone">
            +7 (999) 987-98-98
          </a>
          <button class="modal-close" onclick="window.location.reload();">
          Закрыть окно
        </button>
    </div>
<? } elseif ($arResult["isFormNote"] != "Y") { ?>
	<div class="modal-content form-content">
		<div class="modal-title">
			<?= $arResult['arForm']['NAME']; ?>
		</div>
		<div class="modal-subtitle">
			<?= $arResult['arForm']['DESCRIPTION']; ?>
		</div>
		<div class="modal-form">
			<?= $arResult["FORM_HEADER"] ?>
			<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { ?>
				<? if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] != "checkbox") { ?>
					<? if($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "hidden") {  ?>
						<?= $arQuestion["HTML_CODE"]; ?>
					<? } elseif($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "text") { 
					?>
						<div class="float-input">
							<?= recreateTextField($FIELD_SID, $arQuestion, 'text'); ?>
						</div>
					<? } elseif($arQuestion["STRUCTURE"][0]["FIELD_TYPE"] == "email") { ?>
						<div class="float-input">
							<?= $arQuestion["HTML_CODE"]; ?>
							<label for="<?= $arResult['arForm']['NAME']; ?>_email"><?= $arQuestion['CAPTION']; ?></label>
						</div>
					<? } ?>
				<? } else { ?>
					
					<label class="custom-checkbox-black">
						<?= $arQuestion["HTML_CODE"]; ?>
						<span class="checkmark">
							<svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.3335 5.66406L4.00016 8.33073L10.6668 1.66406" stroke="white" stroke-width="1.5"
									stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</span>
						<span class="checkbox-text">Я согласен на обработку персональных данных и ознакомлен с <a
								href="javascript:void(0)" target="_blank">политикой конфиденциальности</a></span>
					</label>
				<? } ?>
			<? } ?>
				<button type="submit" class="arrow-btn__dark modal-submit" name="web_form_submit" value="<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == "" ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>">
					<span>
						<?= htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == "" ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>
					</span>
					<div class="icon">
						<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M11.4167 6.5L6.41667 11.5M1 6.5H11.4167H1ZM11.4167 6.5L6.41667 1.5L11.4167 6.5Z"
								stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</button>
			</form>
			<? if(!empty($arResult['SOCIALS'])): ?>
			<div class="modal-social__links-title">
				Или свяжитесь с нами в удобном месенджере
			</div>
			<div class="modal-social__links">
				<? foreach($arResult['SOCIALS'] as $soc): ?>
					<? if($soc['ID'] == 1 || $soc['ID'] == 2 || $soc['ID'] == 4): ?>
					<a href="<?= $soc['UF_LINK']; ?>" target="_blank" class="modal-social__link">
						<?= $soc['UF_SVG_CONTACTS']; ?>
					</a>
					<? endif; ?>
				<? endforeach; ?>
			</div>
			<? endif; ?>
			<?= $arResult["FORM_FOOTER"]; ?>
		</div>
	</div>
<? }