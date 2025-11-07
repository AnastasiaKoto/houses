<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arRows = [];

foreach ($arResult["rows"] as $row) {
	if ($row["UF_PICTURE"]) {
		preg_match_all('/src="([^\"]+)"/', $row["UF_PICTURE"], $src);
		$src = $src[1][0];

		$row["UF_PICTURE"] = $src;

		$arRows[] = $row;
	}
}

if (!empty($arRows)) {
    $arResult["rows"] = $arRows;
}