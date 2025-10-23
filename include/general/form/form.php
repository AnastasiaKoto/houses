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
				array(
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "Y",
					"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
					"CACHE_TYPE" => "A",	// Тип кеширования
					"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
					"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
					"EDIT_URL" => "",	// Страница редактирования результата
					"IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
					"LIST_URL" => "",	// Страница со списком результатов
					"SEF_MODE" => "N",	// Включить поддержку ЧПУ
					"SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
					"USE_EXTENDED_ERRORS" => "Y",	// Использовать расширенный вывод сообщений об ошибках
					"VARIABLE_ALIASES" => array(
						"RESULT_ID" => "",
						"WEB_FORM_ID" => "",
					),
					"WEB_FORM_ID" => "1",	// ID веб-формы
					"UNIQUE_PREFIX" => "footer_form"
				),
				false
			); ?>
		</div>
	</div>
</section>