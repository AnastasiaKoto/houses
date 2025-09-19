<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? use Bitrix\Main\Page\Asset; ?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><? $APPLICATION->ShowTitle(); ?></title>
	<? echo $APPLICATION->GetPageProperty('description'); ?>
	<? echo $APPLICATION->GetPageProperty('keywords'); ?>
	<? 
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/splide.min.css');
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/homepage.css');
	Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/main.css');
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/splide.min.js');
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/homepage.js');
	Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/main.js');
  $APPLICATION->ShowHead();
	?>
</head>

<body>
  <div id="panel">
    <? $APPLICATION->ShowPanel(); ?>
  </div>
  <header>
    <nav>
      <div class="container">
        <div class="nav-inner">
          <a href="javascript:void(0)" class="nav-logo">
            <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/logo.svg" alt="logo">
          </a>
          <?$APPLICATION->IncludeComponent("bitrix:menu","",Array(
              "ROOT_MENU_TYPE" => "top", 
              "MAX_LEVEL" => "2", 
              "CHILD_MENU_TYPE" => "left", 
              "USE_EXT" => "Y",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "Y",
              "MENU_CACHE_TYPE" => "N", 
              "MENU_CACHE_TIME" => "3600", 
              "MENU_CACHE_USE_GROUPS" => "Y", 
              "MENU_CACHE_GET_VARS" => "" 
            )
          );?>
          <?/*
          <ul class="nav-menu">
            <li>
              <a href="javascript:void(0)">
                <span>
                  Проекты домов
                </span>
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.5 6.5L8.5 10.5L12.5 6.5" stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <span>
                  Реализованные проекты
                </span>
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.5 6.5L8.5 10.5L12.5 6.5" stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <span>
                  Ипотека
                </span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <span>
                  О компании
                </span>
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.5 6.5L8.5 10.5L12.5 6.5" stroke="#2E2F33" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
              <ul class="nav-submenu">
                <li>
                  <a href="javascript:void(0)">
                    <span>
                      Компания
                    </span>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <span>
                      Вакансии
                    </span>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <span>
                      Новости
                    </span>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <span>
                      Технологии
                    </span>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <span>
                      Документы
                    </span>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a href="javascript:void(0)">
                <span>
                  Индивидуальный проект
                </span>
              </a>
            </li>
          </ul>
          */?>
          <div class="nav-contacts">
            <a href="javascript:void(0)" class="nav-contact icon" target="_blank">
              <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M19.9932 10.5C19.9932 13.1522 18.9396 15.6957 17.0642 17.5711C15.1889 19.4464 12.6453 20.5 9.99316 20.5C7.341 20.5 4.79746 19.4464 2.9221 17.5711C1.04673 15.6957 -0.00683594 13.1522 -0.00683594 10.5C-0.00683594 7.84784 1.04673 5.3043 2.9221 3.42893C4.79746 1.55357 7.341 0.5 9.99316 0.5C12.6453 0.5 15.1889 1.55357 17.0642 3.42893C18.9396 5.3043 19.9932 7.84784 19.9932 10.5ZM10.3519 7.8825C9.37941 8.2875 7.43441 9.125 4.51941 10.395C4.04691 10.5825 3.79816 10.7675 3.77566 10.9475C3.73816 11.2512 4.11941 11.3713 4.63816 11.535L4.85691 11.6038C5.36691 11.77 6.05441 11.9637 6.41066 11.9713C6.73566 11.9788 7.09691 11.8463 7.49566 11.5713C10.2194 9.7325 11.6257 8.80375 11.7132 8.78375C11.7757 8.76875 11.8632 8.75125 11.9207 8.80375C11.9794 8.855 11.9732 8.95375 11.9669 8.98C11.9294 9.14125 10.4332 10.5312 9.65941 11.2512C9.41816 11.4762 9.24691 11.635 9.21191 11.6713C9.13484 11.75 9.0565 11.8275 8.97691 11.9038C8.50191 12.3612 8.14691 12.7038 8.99566 13.2638C9.40441 13.5338 9.73191 13.755 10.0582 13.9775C10.4132 14.22 10.7682 14.4613 11.2282 14.7638C11.3444 14.8387 11.4569 14.92 11.5657 14.9975C11.9794 15.2925 12.3532 15.5575 12.8119 15.515C13.0794 15.49 13.3557 15.24 13.4957 14.49C13.8269 12.7188 14.4782 8.8825 14.6282 7.30125C14.6373 7.1698 14.6319 7.03775 14.6119 6.9075C14.6001 6.8024 14.5493 6.70557 14.4694 6.63625C14.3557 6.55774 14.2201 6.51706 14.0819 6.52C13.7069 6.52625 13.1282 6.7275 10.3519 7.8825Z"
                  fill="white" />
              </svg>
            </a>
            <a href="tel:+7999989809" class="nav-contact phone" target="_blank">
              <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M10 0.5C15.5228 0.5 20 4.97715 20 10.5C20 16.0228 15.5228 20.5 10 20.5C4.47715 20.5 0 16.0228 0 10.5C0 4.97715 4.47715 0.5 10 0.5ZM5.49219 4.98633C4.85962 4.98638 4.36158 5.50928 4.45605 6.13477C4.69197 7.6964 5.38717 10.5277 7.41992 12.5605C9.55483 14.6955 12.63 15.622 14.3223 15.9902C14.9758 16.1325 15.5557 15.6219 15.5557 14.9531V12.9424L13.3779 12.1123L11.0674 12.5605C9.50673 11.7772 8.5425 10.8772 7.98145 9.47461L8.41309 7.15723L7.59668 4.98633H5.49219Z"
                  fill="white" />
              </svg>
              <span>
                +7 (999) 98-98-09
              </span>
            </a>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <main>
