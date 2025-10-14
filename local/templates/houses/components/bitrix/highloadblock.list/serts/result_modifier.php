<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arRows = [];

foreach ($arResult["rows"] as $row) {
	if ($row["UF_PDF"]) {
		preg_match_all('/href="([^\"]+)"/', $row["UF_PDF"], $src);
		$src = $src[1][0];

		$row["UF_PDF"] = $src;

		$arRows[] = $row;
	}
}

if (!empty($arRows)) {
    $arResult["rows"] = $arRows;
}