<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

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
$containerName = 'container-' . $navParams['NavNum'];
?>
<!-- items-container -->
<? if(!empty($arResult['ITEMS'])): ?>
<div class="catalog-items" data-entity="items-row" id="<?= $containerName ?>">
	<? foreach($arResult['ITEMS'] as $item): ?>
	<div class="catalog-item" onclick="window.location='<?= $item['DETAIL_PAGE_URL']; ?>'" data-entity="item">
		<? if(!empty($item['PROPERTIES']['GALLERY']['VALUE'])): ?>
		<div class="splide catalog-item__images">
			<div class="splide__track">
				<ul class="splide__list catalog-item__image-items">
					<? foreach($item['PROPERTIES']['GALLERY']['VALUE'] as $img): ?>
					<li class="splide__slide catalog-item__image-item">
						<img src="<?= CFile::GetPath($img); ?>" alt="<?= $item['NAME']; ?>">
					</li>
					<? endforeach; ?>
				</ul>
			</div>
		</div>
		<? else: ?>
		<div class="catalog-item__images">
			<img src="/local/templates/houses/assets/img/no-photo.jpeg" alt="not-image">
		</div>
		<? endif; ?>
		<div class="catalog-item__info">
			<div class="catalog-item__head">
				<div class="catalog-item__name">
					<?= $item['NAME']; ?>
				</div>
				<div class="catalog-item__tag">
					Whitebox
				</div>
			</div>
			<div class="catalog-item__body">
				<div class="catalog-item__spec">
					<div class="catalog-item__spec-item">
						<div class="catalog-item__spec-item__icon">
							<img src="./assets/img/sp1.svg" alt="img">
						</div>
						<div class="catalog-item__spec-item__text">
							123 м<sup>2</sup>
						</div>
					</div>
					<div class="catalog-item__spec-item">
						<div class="catalog-item__spec-item__icon">
							<img src="./assets/img/sp2.svg" alt="img">
						</div>
						<div class="catalog-item__spec-item__text">
							4
						</div>
					</div>
					<div class="catalog-item__spec-item">
						<div class="catalog-item__spec-item__icon">
							<img src="./assets/img/sp3.svg" alt="img">
						</div>
						<div class="catalog-item__spec-item__text">
							12x16 м
						</div>
					</div>
					<div class="catalog-item__spec-item">
						<div class="catalog-item__spec-item__icon">
							<img src="./assets/img/sp4.svg" alt="img">
						</div>
						<div class="catalog-item__spec-item__text">
							2
						</div>
					</div>
				</div>
				<a href="javascript:void(0)" class="catalog-item__link">
					<span>
						2 500 000 ₽
					</span>
					<svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M15.7502 10L10.7502 15M5.3335 10H15.7502H5.3335ZM15.7502 10L10.7502 5L15.7502 10Z"
							stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>
			</div>
		</div>
	</div>
	<? endforeach; ?>
</div>
<? endif; ?>
<!-- items-container -->

<?
if ($showLazyLoad) {
	?>
	<div class="show-more-container">
		<a href="javascript:void(0)" class="show-more"
			data-use="show-more-<?= $navParams['NavNum'] ?>">
			<?= $arParams['MESS_BTN_LAZY_LOAD'] ?>
		</a>
	</div>
	<?
}
?>

<?
if ($showBottomPager) {
	?>
	<!-- pagination-container -->
	<div data-pagination-num="<?=$navParams['NavNum']?>">
		<?=$arResult['NAV_STRING']?>
	</div>
	<!-- pagination-container -->
	<?
}

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