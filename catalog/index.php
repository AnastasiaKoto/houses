<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Каталог");

$APPLICATION->IncludeComponent("bitrix:catalog", "house_projects", Array(
	"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"IBLOCK_TYPE" => "products",	// Тип инфоблока
		"IBLOCK_ID" => "6",	// Инфоблок
		"HIDE_NOT_AVAILABLE" => "N",
		"BASKET_URL" => "",	// URL, ведущий на страницу с корзиной покупателя
		"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"PRODUCT_QUANTITY_VARIABLE" => "",	// Название переменной, в которой передается количество товара
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"COMMON_SHOW_CLOSE_POPUP" => "N",
		"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
		"SEF_FOLDER" => "/catalog/",	// Каталог ЧПУ (относительно корня сайта)
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
		"ADD_ELEMENT_CHAIN" => "Y",	// Включать название элемента в цепочку навигации
		"USE_ELEMENT_COUNTER" => "N",	// Использовать счетчик просмотров
		"USE_SALE_BESTSELLERS" => "N",
		"COMPARE_POSITION_FIXED" => "N",
		"COMPARE_POSITION" => "",
		"USE_FILTER" => "Y",	// Показывать фильтр
		"FILTER_NAME" => "",	// Фильтр
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_HIDE_ON_MOBILE" => "N",	// Скрывать умный фильтр на мобильных устройствах
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PRICE_CODE" => array(
			0 => "BASE",
		),
		"FILTER_OFFERS_FIELD_CODE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DETAIL_PICTURE",
			2 => "",
		),
		"FILTER_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
		"TOP_ADD_TO_BASKET_ACTION" => "ADD",
		"SECTION_ADD_TO_BASKET_ACTION" => "ADD",
		"DETAIL_ADD_TO_BASKET_ACTION" => array(
			0 => "BUY",
		),
		"DETAIL_SHOW_BASIS_PRICE" => "Y",
		"FILTER_VIEW_MODE" => "VERTICAL",	// Вид отображения умного фильтра
		"USE_REVIEW" => "N",
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "N",
		"REVIEW_AJAX_POST" => "N",
		"PATH_TO_SMILE" => "",
		"FORUM_ID" => "",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "N",
		"POST_FIRST_MESSAGE" => "N",
		"USE_COMPARE" => "N",	// Разрешить сравнение товаров
		"PRICE_CODE" => array(	// Тип цены
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"PRICE_VAT_INCLUDE" => "N",	// Включать НДС в цену
		"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
		"PRODUCT_PROPERTIES" => "",
		"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => "RUB",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "COLOR_REF",
			1 => "SIZES_SHOES",
			2 => "SIZES_CLOTHES",
		),
		"SHOW_TOP_ELEMENTS" => "N",	// Выводить топ элементов
		"SECTION_COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
		"SECTION_TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
		"SECTIONS_VIEW_MODE" => "TEXT",	// Вид списка подразделов
		"SECTIONS_SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
		"PAGE_ELEMENT_COUNT" => "9",	// Количество элементов на странице
		"LINE_ELEMENT_COUNT" => "3",	// Количество элементов, выводимых в одной строке таблицы
		"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем товары в разделе
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки товаров в разделе
		"ELEMENT_SORT_FIELD2" => "id",	// Поле для второй сортировки товаров в разделе
		"ELEMENT_SORT_ORDER2" => "desc",	// Порядок второй сортировки товаров в разделе
		"LIST_PROPERTY_CODE" => array(
			0 => "NEWPRODUCT",
			1 => "SALELEADER",
			2 => "SPECIALOFFER",
			3 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"LIST_META_KEYWORDS" => "UF_KEYWORDS",	// Установить ключевые слова страницы из свойства раздела
		"LIST_META_DESCRIPTION" => "UF_META_DESCRIPTION",	// Установить описание страницы из свойства раздела
		"LIST_BROWSER_TITLE" => "UF_BROWSER_TITLE",	// Установить заголовок окна браузера из свойства раздела
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "DETAIL_PICTURE",
			3 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "ARTNUMBER",
			1 => "COLOR_REF",
			2 => "SIZES_SHOES",
			3 => "SIZES_CLOTHES",
			4 => "MORE_PHOTO",
			5 => "",
		),
		"LIST_OFFERS_LIMIT" => "0",
		"SECTION_BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",	// Режим показа детальной картинки
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",	// Добавлять детальную картинку в слайдер
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",	// Показ описания для анонса на детальной странице
		"DETAIL_PROPERTY_CODE" => array(
			0 => "NEWPRODUCT",
			1 => "MANUFACTURER",
			2 => "MATERIAL",
			3 => "",
		),
		"DETAIL_META_KEYWORDS" => "KEYWORDS",	// Установить ключевые слова страницы из свойства
		"DETAIL_META_DESCRIPTION" => "META_DESCRIPTION",	// Установить описание страницы из свойства
		"DETAIL_BROWSER_TITLE" => "TITLE",	// Установить заголовок окна браузера из свойства
		"DETAIL_SET_CANONICAL_URL" => "N",	// Устанавливать канонический URL
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",	// Использовать код группы из переменной, если не задан раздел элемента
		"SHOW_DEACTIVATED" => "N",	// Показывать деактивированные товары
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(
			0 => "ARTNUMBER",
			1 => "COLOR_REF",
			2 => "SIZES_SHOES",
			3 => "SIZES_CLOTHES",
			4 => "MORE_PHOTO",
			5 => "",
		),
		"DETAIL_BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
		"DETAIL_STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для детального показа элемента
		"LINK_IBLOCK_TYPE" => "products",	// Тип инфоблока, элементы которого связаны с текущим элементом
		"LINK_IBLOCK_ID" => "11",	// ID инфоблока, элементы которого связаны с текущим элементом
		"LINK_PROPERTY_SID" => "HOUSE_VARIABLES",	// Свойство, в котором хранится связь
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",	// URL на страницу, где будет показан список связанных элементов
		"USE_ALSO_BUY" => "N",
		"ALSO_BUY_ELEMENT_COUNT" => "3",
		"ALSO_BUY_MIN_BUYES" => "2",
		"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",	// Не подключать js-библиотеки в компоненте
		"USE_GIFTS_DETAIL" => "N",
		"USE_GIFTS_MAIN_PR_SECTION_LIST" => "N",
		"USE_GIFTS_SECTION" => "N",
		"GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "3",
		"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
		"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "3",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",
		"GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "3",
		"GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "Y",
		"USE_STORE" => "N",	// Показывать блок "Количество товара на складе"
		"STORES" => array(
			0 => "1",
		),
		"USE_MIN_AMOUNT" => "N",
		"USER_FIELDS" => array(
			0 => "",
		),
		"FIELDS" => array(
			0 => "ADDRESS",
			1 => "PHONE",
		),
		"SHOW_EMPTY_STORE" => "Y",
		"SHOW_GENERAL_STORE_INFORMATION" => "N",
		"STORE_PATH" => "/store/#store_id#",
		"MAIN_TITLE" => "Наличие на складах",
		"USE_BIG_DATA" => "Y",
		"BIG_DATA_RCM_TYPE" => "bestsell",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_TEMPLATE" => "arrows",	// Шаблон постраничной навигации
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"PAGER_TITLE" => "Товары",	// Название категорий
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_BASE_LINK_ENABLE" => "Y",	// Включить обработку ссылок
		"PAGER_BASE_LINK" => "",	// Url для построения ссылок (по умолчанию - автоматически)
		"PAGER_PARAMS_NAME" => "arrPager",	// Имя массива с переменными для построения ссылок
		"SET_STATUS_404" => "Y",	// Устанавливать статус 404
		"SHOW_404" => "Y",	// Показ специальной страницы
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"ADD_PICT_PROP" => "-",	// Дополнительная картинка основного товара
		"LABEL_PROP" => "NEWPRODUCT",	// Свойство меток товара
		"PRODUCT_DISPLAY_MODE" => "Y",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(
			0 => "COLOR_REF",
			1 => "SIZES_SHOES",
			2 => "SIZES_CLOTHES",
			3 => "",
		),
		"DETAIL_DISPLAY_NAME" => "Y",	// Выводить название элемента
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
		"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
		"MESS_BTN_COMPARE" => "Сравнение",	// Текст кнопки "Сравнение"
		"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
		"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
		"TOP_VIEW_MODE" => "SECTION",
		"DETAIL_USE_VOTE_RATING" => "N",	// Включить рейтинг товара
		"DETAIL_VOTE_DISPLAY_AS_RATING" => "rating",	// В качестве рейтинга показывать
		"DETAIL_USE_COMMENTS" => "N",	// Включить отзывы о товаре
		"DETAIL_BLOG_USE" => "N",	// Использовать комментарии
		"DETAIL_VK_USE" => "N",	// Использовать Вконтакте
		"DETAIL_FB_USE" => "N",	// Использовать Facebook
		"DETAIL_FB_APP_ID" => "",	// Идентификатор приложения (APP_ID)
		"DETAIL_BRAND_USE" => "N",	// Использовать компонент "Бренды"
		"SIDEBAR_SECTION_SHOW" => "Y",	// Показывать правый блок в списке товаров
		"SIDEBAR_DETAIL_SHOW" => "N",	// Показывать правый блок на детальной странице
		"SIDEBAR_PATH" => "",	// Путь к включаемой области для вывода информации в правом блоке
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE#/",
			"element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"compare" => "",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>