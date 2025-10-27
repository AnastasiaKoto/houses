<section id="question" class="section question-form">
	<div class="container">
		<div class="question-form__inner">
			<div class="section-title main_section-title">
				<? $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/general/form/section_title.php"
					)
				); ?>
			</div>
			<div class="question-form__form-subtitle main_question-form__form-subtitle">
				<? $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "standard.php",
						"PATH" => "/include/general/form/section_descr.php"
					)
				); ?>
			</div>
			<? $APPLICATION->IncludeComponent(
				"bitrix:form.result.new", 
				"callback", 
				[
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "A",
					"CHAIN_ITEM_LINK" => "",
					"CHAIN_ITEM_TEXT" => "",
					"EDIT_URL" => "",
					"IGNORE_CUSTOM_TEMPLATE" => "N",
					"LIST_URL" => "",
					"SEF_MODE" => "N",
					"SUCCESS_URL" => "",
					"USE_EXTENDED_ERRORS" => "Y",
					"WEB_FORM_ID" => "1",
					"UNIQUE_PREFIX" => "footer_form",
					"VARIABLE_ALIASES" => [
						"WEB_FORM_ID" => "",
						"RESULT_ID" => "",
					]
				],
				false
			); ?>
		</div>
	</div>
</section>