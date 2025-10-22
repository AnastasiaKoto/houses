<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
</main>
<footer>
  <div class="overlay"></div>
  <div class="modal" id="presentation">
    <div class="modal-inner">
      <? $APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"modal",
				array(
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
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
					"WEB_FORM_ID" => "3",	// ID веб-формы
          "UNIQUE_PREFIX" => "presentation_form"
				),
				false
			); ?>
    </div>
  </div>
  <div class="modal" id="estimate">
    <div class="modal-inner">
      <? $APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"modal",
				array(
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
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
					"WEB_FORM_ID" => "2",	// ID веб-формы
          "UNIQUE_PREFIX" => "estimate_form"
				),
				false
			); ?>
    </div>
  </div>
  <div class="modal" id="manager">
    <div class="modal-inner">
      <? $APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"modal",
				array(
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
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
          "UNIQUE_PREFIX" => "modal_form"
				),
				false
			); ?>
    </div>
  </div>

  <div class="container">
    <div class="footer-inner">
      <div class="footer-top">
        <div class="footer-left">
          <a href="javascript:void(0)" class="footer-logo">
            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/logo.svg" alt="img">
          </a>
          <? $APPLICATION->IncludeComponent(
            "bitrix:highloadblock.list",
            "socials",
            array(
              "BLOCK_ID" => HL_SOCIAL_NETWORKS_ID,	// ID highload блока
              "CHECK_PERMISSIONS" => "N",	// Проверять права доступа
              "DETAIL_URL" => "",	// Путь к странице просмотра записи
              "FILTER_NAME" => "",	// Идентификатор фильтра
              "PAGEN_ID" => "",	// Идентификатор страницы
              "ROWS_PER_PAGE" => "",	// Разбить по страницам количеством
              "SORT_FIELD" => "ID",	// Поле сортировки
              "SORT_ORDER" => "ASC",	// Направление сортировки
            ),
            false
          ); ?>
        </div>
        <ul class="footer-items">
          <li class="footer-item">
            <? $APPLICATION->IncludeComponent(
              "bitrix:menu",
              "footer_menu",
              array(
                "ROOT_MENU_TYPE" => "bottom_projects",	// Тип меню для первого уровня
                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "Y",	// Разрешить несколько активных пунктов одновременно
                "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                "COMPONENT_TEMPLATE" => "",
                "MENU_TITLE" => "Проекты домов"
              ),
              false
            ); ?>
          </li>
          <li class="footer-item">
            <? $APPLICATION->IncludeComponent(
              "bitrix:menu",
              "footer_menu",
              array(
                "ROOT_MENU_TYPE" => "bottom_portfolio",	// Тип меню для первого уровня
                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "Y",	// Разрешить несколько активных пунктов одновременно
                "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                "COMPONENT_TEMPLATE" => "",
                "MENU_TITLE" => "Портфолио проектов"
              ),
              false
            ); ?>
          </li>
          <li class="footer-item">
            <? $APPLICATION->IncludeComponent(
              "bitrix:menu",
              "footer_menu",
              array(
                "ROOT_MENU_TYPE" => "bottom_company",	// Тип меню для первого уровня
                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "Y",	// Разрешить несколько активных пунктов одновременно
                "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                "COMPONENT_TEMPLATE" => "",
                "MENU_TITLE" => "О компании"
              ),
              false
            ); ?>
          </li>
          <li class="footer-item">
            <? $APPLICATION->IncludeComponent(
              "bitrix:menu",
              "footer_menu",
              array(
                "ROOT_MENU_TYPE" => "bottom_dop",	// Тип меню для первого уровня
                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "Y",	// Разрешить несколько активных пунктов одновременно
                "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                "COMPONENT_TEMPLATE" => "",
                "MENU_TITLE" => "Дополнительно"
              ),
              false
            ); ?>
          </li>
          <li class="footer-item">
            <? $APPLICATION->IncludeComponent(
              "bitrix:main.include",
              "",
              array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "",
                "EDIT_TEMPLATE" => "standard.php",
                "PATH" => "/include/general/footer/footer_contacts.php"
              )
            ); ?>
          </li>
        </ul>
      </div>
      <div class="footer-devider"></div>
      <div class="footer-copy">
        <div class="copyright">
          ©2025 Дом Готов. Все права защищены.
        </div>
        <div class="footer-reqs">
          <div class="footer-reqs__item">
            ООО «10 ДОМОВ»
          </div>
          <div class="footer-reqs__item">
            ИНН 397092663596
          </div>
          <div class="footer-reqs__item">
            КПП 265245504
          </div>
          <div class="footer-reqs__item">
            ОГРН 3076747289759
          </div>
        </div>
      </div>
      <div class="footer-decor">
        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/f-logo-decor.svg" alt="img">
      </div>
    </div>
  </div>
</footer>
</body>

</html>