<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Технологии");
?>
<section class="section vacancy">
    <div class="container">
        <h1>
            <? $APPLICATION->ShowTitle(); ?>
        </h1>
        <div class="vacancy-subtitle">
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
		"PATH" => "/include/general/form/form.php"
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
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>