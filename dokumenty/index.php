<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Документы");
?>
<?$APPLICATION->IncludeComponent("bitrix:highloadblock.list", "documents", Array(
	"BLOCK_ID" => HL_DOCUMENTS_ID,	// ID highload блока
		"CHECK_PERMISSIONS" => "N",	// Проверять права доступа
		"DETAIL_URL" => "",	// Путь к странице просмотра записи
		"FILTER_NAME" => "",	// Идентификатор фильтра
		"PAGEN_ID" => "",	// Идентификатор страницы
		"ROWS_PER_PAGE" => "",	// Разбить по страницам количеством
		"SORT_FIELD" => "",	// Поле сортировки
		"SORT_ORDER" => "",	// Направление сортировки
	),
	false
);?>
<?$APPLICATION->IncludeComponent("bitrix:highloadblock.list", "serts", Array(
	"BLOCK_ID" => HL_CERTIFICATES_ID,	// ID highload блока
		"CHECK_PERMISSIONS" => "N",	// Проверять права доступа
		"DETAIL_URL" => "",	// Путь к странице просмотра записи
		"FILTER_NAME" => "",	// Идентификатор фильтра
		"PAGEN_ID" => "",	// Идентификатор страницы
		"ROWS_PER_PAGE" => "",	// Разбить по страницам количеством
		"SORT_FIELD" => "",	// Поле сортировки
		"SORT_ORDER" => "",	// Направление сортировки
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>