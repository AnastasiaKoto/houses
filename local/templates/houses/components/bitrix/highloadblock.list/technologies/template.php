<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */


if (!empty($arResult['ERROR'])) {
	echo $arResult['ERROR'];
	return false;
}
if (!empty($arResult['rows'])):
	?>
	<section class="section icon-block">
		<div class="container">
			<? if(!empty($arParams['BLOCK_TITLE'])): ?>
			<div class="section-title">
				<?= $arParams['BLOCK_TITLE']; ?>
			</div>
			<? endif; ?>
			<? if(!empty($arParams['BLOCK_DESCR'])): ?>
			<div class="section-subtitle">
				<?= $arParams['BLOCK_DESCR']; ?>
			</div>
			<? endif; ?>
			<ul class="icon-block__items">
				<? foreach($arResult['rows'] as $row): ?>
				<li class="icon-block__item">
					<div class="icon-block__item-icon">
						<img src="<?= $row['UF_ICON']; ?>" alt="<?= $row['UF_TITLE']; ?>">
					</div>
					<div class="icon-block__item-title">
						<?= $row['UF_TITLE']; ?>
					</div>
					<div class="icon-block__item-text">
						<?= $row['UF_DESCR']; ?>
					</div>
				</li>
				<? endforeach; ?>
			</ul>
		</div>
	</section>
<? endif; ?>