<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Технологии");
?>
<section class="section">
    <div class="container">
        <h1 class="section-title">
            <? $APPLICATION->ShowTitle(false); ?>
        </h1>
        <div class="section-subtitle">
            <? $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "",
                    "EDIT_TEMPLATE" => "standard.php",
                    "PATH" => "/include/technology/page_descr.php"
                )
            ); ?>
        </div>
    </div>
</section>
<? $APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"EDIT_TEMPLATE" => "standard.php",
		"PATH" => "/include/general/blocks/features.php"
	)
); ?>
<? $APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"EDIT_TEMPLATE" => "standard.php",
		"PATH" => "/include/general/blocks/unics.php"
	)
); ?>
<? $APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"EDIT_TEMPLATE" => "standard.php",
		"PATH" => "/include/technology/compare_block/section_title.php"
	)
); ?>
<? $APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"EDIT_TEMPLATE" => "standard.php",
		"PATH" => "/include/technology/compare_block/section_descr.php"
	)
); ?>
<? $APPLICATION->IncludeComponent(
"bitrix:highloadblock.list",
"",
array(
	"BLOCK_ID" => HL_COMPARE_ID,	// ID highload блока
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
<? $APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"EDIT_TEMPLATE" => "standard.php",
		"PATH" => "/include/general/form/form.php"
	)
); ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>