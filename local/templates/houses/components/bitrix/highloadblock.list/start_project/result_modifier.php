<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arRows = [];

foreach ($arResult["rows"] as $row) {
	if ($row["UF_ICON"]) {
		preg_match_all('/src="([^\"]+)"/', $row["UF_ICON"], $src);
		$src = $src[1][0];

		$row["UF_ICON"] = $src;

		$arRows[] = $row;
	}
}

if (!empty($arRows)) {
    $arResult["rows"] = $arRows;
}