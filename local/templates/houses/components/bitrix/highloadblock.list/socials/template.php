<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */


if(!empty($arResult['rows'])): 
?>
<div class="footer-social">
	<? foreach ($arResult['rows'] as $row): ?>
		<a href="<?= trim($row['UF_LINK']); ?>">
			<?= html_entity_decode(htmlspecialchars_decode($row['UF_SVG'])); ?>
		</a>
	<? endforeach; ?>
</div>
<? endif; ?>