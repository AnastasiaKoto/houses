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
				<div class="teches__head">
					<div class="section-title">
						<?= $arParams['BLOCK_TITLE']; ?>
					</div>
					<a href="/company/tekhnologii/" class="arrow-btn__dark"
						data-move-target=".tech_block" data-move-break="700">
						<span>
							Подробнее про наши технологии
						</span>
						<div class="icon">
							<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="#000"
									stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
					</a>
				</div>
			<? endif; ?>
			<? if(!empty($arParams['BLOCK_DESCR'])): ?>
			<div class="section-subtitle">
				<?= $arParams['BLOCK_DESCR']; ?>
			</div>
			<? endif; ?>
			<ul class="icon-block__items tech_block">
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