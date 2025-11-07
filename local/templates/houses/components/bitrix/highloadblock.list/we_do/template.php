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
	<section class="section about-flow">
		<div class="container">
			<div class="section-title">
				Что мы делаем
			</div>
			<ul class="about-flow__items">
				<? foreach($arResult['rows'] as $row): ?>
				<li class="about-flow__item">
					<div class="about-flow__item-image">
						<img src="<?= $row['UF_PICTURE']; ?>" alt="<?= $row['UF_TITLE']; ?>">
					</div>
					<div class="about-flow__item-info">
						<div class="about-flow__item-title">
							<?= $row['UF_TITLE']; ?>
						</div>
						<div class="about-flow__item-text">
							<?= $row['UF_DESCR']; ?>
						</div>
					</div>
				</li>
				<? endforeach; ?>
			</ul>
		</div>
	</section>
<? endif; ?>