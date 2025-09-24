<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="footer-menu">
<li><a href="javascript:void(0)"><?= $arParams['MENU_TITLE']; ?></a></li>
<?
foreach($arResult as $arItem):
?>
	<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>

<?endforeach?>

</ul>
<?endif?>