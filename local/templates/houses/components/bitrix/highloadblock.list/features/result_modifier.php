<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arRows = [];

foreach ($arResult["rows"] as $row) {
	if ($row["UF_ICON"]) {
		preg_match_all('/href="([^\"]+)"/', $row["UF_ICON"], $src_picture);
		$src = $src_picture[1][0];
		$info = new SplFileInfo($src);
		$type = $info->getExtension();

		$row["UF_ICON"] = $src;

		$arRows[] = $row;
	}
}

if (!empty($arRows)) {
    $arResult["rows"] = $arRows;
}