<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");
?>

<section class="section not-found">
	<div class="container">
		<div class="not-found__inner">
			<div class="nf-wave">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/nf-bg.png" alt="img">
			</div>
			<div class="nf-ten">
				<picture>
					<!-- Для мобильных устройств -->
					<source srcset="<?= SITE_TEMPLATE_PATH ?>/assets/img/nf-ten-mobile.svg" media="(max-width: 700px)">
					<source srcset="<?= SITE_TEMPLATE_PATH ?>/assets/img/nf-ten.svg" media="(min-width: 701px)">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/img/nf-ten.svg" alt="img">
				</picture>
			</div>

			<div class="not-found__title">
				Ошибка 404
			</div>
			<div class="not-found__subtitle">
				Страница не найдена. Вероятно, она на стадии разработки. Пожалуйста, перейдите на главную страницу сайта
			</div>
			<a href="/" class="arrow-orange__link">
				<span>
					На главную
				</span>
				<div class="icon">
					<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.4167 6L6.41667 11M1 6H11.4167H1ZM11.4167 6L6.41667 1L11.4167 6Z" stroke="#2E2F33"
							stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
			</a>
		</div>
	</div>
</section>

<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>