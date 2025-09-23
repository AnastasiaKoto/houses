<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die(); ?>

<? if (!empty($arResult)): ?>
	<ul class="nav-menu">
		<?
		$previousLevel = 0;
		foreach ($arResult as $arItem): ?>
			<? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
				<?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
			<? endif ?>
			<? if ($arItem["IS_PARENT"]): ?>
				<? if ($arItem["DEPTH_LEVEL"] == 1): ?>
					<li <? if ($arItem["SELECTED"]) { echo 'class="active"'; } ?>>
						<a href="<?= $arItem["LINK"] ?>">
							<span>
								<?= $arItem["TEXT"] ?>
							</span>
							<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.5 6.5L8.5 10.5L12.5 6.5" stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</a>
						<ul class="nav-submenu">
				<? else: ?>
					<li <? if ($arItem["SELECTED"]) { echo 'class="active"'; } ?>>
						<a href="<?= $arItem["LINK"] ?>">
							<span>
								<?= $arItem["TEXT"] ?>
							</span>
						</a>
					</li>
				<? endif ?>
			<? else: ?>
				<li <? if ($arItem["SELECTED"]) { echo 'class="active"'; } ?>>
					<a href="<?= $arItem["LINK"] ?>">
						<span>
							<?= $arItem["TEXT"] ?>
						</span>
					</a>
				</li>
			<? endif; ?>

			<? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

		<? endforeach ?>
		
		<? if ($previousLevel > 1)://close last item tags ?>
			<?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
		<? endif ?>

	</ul>
<? endif; ?>