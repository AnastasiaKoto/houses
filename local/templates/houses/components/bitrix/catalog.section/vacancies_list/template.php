<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;
$APPLICATION->AddChainItem($arResult["NAME"]);
$this->setFrameMode(true);
if (!empty($arResult['NAV_RESULT'])) {
	$navParams = array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
} else {
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1) {
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$obName = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-' . $navParams['NavNum'];?>
<!-- items-container -->
<?if (!empty($arResult['ITEMS'])):
	?>
	<div class="vacancy-items catalog-items" data-entity="items-row" id="<?= $containerName ?>">
		<? foreach($arResult['ITEMS'] as $arItem): ?>
		<div class="vacancy-item catalog-item" data-entity="item">
			<div class="vacancy-item__name">
				<?= $arItem['NAME']; ?>
			</div>
			<div class="vacancy-item-salary">
				<?= $arItem['DISPLAY_PROPERTIES']['PAY']['VALUE']; ?>
			</div>
			<div class="vacancy-item__conditions">
				<?= $arItem['PREVIEW_TEXT']; ?>
			</div>
			<a href="<?= $arItem['DETAIL_PAGE_URL']; ?>" class="vacancy-item__link">
				Посмотреть
			</a>
		</div>
		<? endforeach; ?>
	</div>
<? endif; ?>
<!-- items-container -->
<?
	if ($showLazyLoad) {
		?>
		<div class="show-more-container">
			<a href="javascript:void(0)" class="show-more" data-use="show-more-<?= $navParams['NavNum'] ?>">
				<?= $arParams['MESS_BTN_LAZY_LOAD'] ?>
			</a>
		</div>
		<?
	}
	?>
<?

$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
?>
<script>
	BX.message({
		BTN_MESSAGE_BASKET_REDIRECT: '<?= GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
		BTN_MESSAGE_LAZY_LOAD: '<?= CUtil::JSEscape($arParams['MESS_BTN_LAZY_LOAD']) ?>',
		BTN_MESSAGE_LAZY_LOAD_WAITER: '<?= GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_LAZY_LOAD_WAITER') ?>'
	});

	var <?= $obName ?> = new JCCatalogSectionComponent({
		siteId: '<?= CUtil::JSEscape($component->getSiteId()) ?>',
		componentPath: '<?= CUtil::JSEscape($componentPath) ?>',
		navParams: <?= CUtil::PhpToJSObject($navParams) ?>,
		deferredLoad: false,
		initiallyShowHeader: false,
		bigData: <?= CUtil::PhpToJSObject($arResult['BIG_DATA'] ?? []) ?>,
		lazyLoad: !!'<?= $showLazyLoad ?>',
		loadOnScroll: false,
		template: '<?= CUtil::JSEscape($signedTemplate) ?>',
		ajaxId: '<?= CUtil::JSEscape($arParams['AJAX_ID'] ?? '') ?>',
		parameters: '<?= CUtil::JSEscape($signedParams) ?>',
		container: '<?= $containerName ?>'
	});
</script>
<!-- component-end -->