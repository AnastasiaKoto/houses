<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */


if(!empty($arResult['rows'])): 
?>
<div class="contats-social__items">
	<? foreach ($arResult['rows'] as $row): ?>
		<a href="<?= trim($row['UF_LINK']); ?>">
			<?= html_entity_decode(htmlspecialchars_decode($row['UF_SVG_CONTACTS'])); ?>
		</a>
	<? endforeach; ?>
</div>
<? endif; ?>