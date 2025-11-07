<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arRows = [];

foreach ($arResult["rows"] as $row) {
	if ($row["UF_IMG"] || $row["UF_IMG_MOBILE"]) {
		preg_match_all('/src="([^\"]+)"/', $row["UF_IMG"], $src);
		preg_match_all('/src="([^\"]+)"/', $row["UF_IMG_MOBILE"], $src_mob);
		$src = $src[1][0];
		$src_mob = $src_mob[1][0];

		$row["UF_IMG"] = $src;
		$row["UF_IMG_MOBILE"] = $src_mob;

		$arRows[] = $row;
	}
}

if (!empty($arRows)) {
    $arResult["rows"] = $arRows;
}