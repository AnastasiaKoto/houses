<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
<section class="section contacts">
    <div class="container">
        <div class="contacts-inner">
            <div class="contacts-info">
                <h1>
                    <? $APPLICATION->ShowTitle(); ?>
                </h1>
                <div class="contacts-description">
                    <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                            "AREA_FILE_SHOW" => "file", 
                            "AREA_FILE_SUFFIX" => "",
                            "EDIT_TEMPLATE" => "standard.php",
                            "PATH" => "/include/contacts/page_descr.php" 
                        )
                    );?>
                </div>
                <div class="contacts-items">
                    <div class="contacts-item">
                        <div class="contacts-item__label">
                            Адрес офиса
                        </div>
                        <div class="contacts-item__text">
                            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                                    "AREA_FILE_SHOW" => "file", 
                                    "AREA_FILE_SUFFIX" => "",
                                    "EDIT_TEMPLATE" => "standard.php",
                                    "PATH" => "/include/contacts/address.php" 
                                )
                            );?>
                        </div>
                    </div>
                    <div class="contacts-item">
                        <div class="contacts-item__label">
                            Время работы офиса
                        </div>
                        <div class="contacts-item__text">
                            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                                    "AREA_FILE_SHOW" => "file", 
                                    "AREA_FILE_SUFFIX" => "",
                                    "EDIT_TEMPLATE" => "standard.php",
                                    "PATH" => "/include/contacts/worktime.php" 
                                )
                            );?>
                        </div>
                    </div>
                    <div class="contacts-item">
                        <div class="contacts-item__label">
                            Номер для связи
                        </div>
                        <div class="contacts-item__text">
                            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                                    "AREA_FILE_SHOW" => "file", 
                                    "AREA_FILE_SUFFIX" => "",
                                    "EDIT_TEMPLATE" => "standard.php",
                                    "PATH" => "/include/contacts/number.php" 
                                )
                            );?>
                        </div>
                    </div>
                    <div class="contacts-item">
                        <div class="contacts-item__label">
                            Электронная почта
                        </div>
                        <div class="contacts-item__text">
                            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                                    "AREA_FILE_SHOW" => "file", 
                                    "AREA_FILE_SUFFIX" => "",
                                    "EDIT_TEMPLATE" => "standard.php",
                                    "PATH" => "/include/contacts/email.php" 
                                )
                            );?>
                        </div>
                    </div>
                </div>
                <div class="contats-social">
                    <div class="contats-social__label">
                        Социальные сети
                    </div>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:highloadblock.list", 
                        "contacts_socials", 
                        [
                            "BLOCK_ID" => HL_SOCIAL_NETWORKS_ID,
                            "CHECK_PERMISSIONS" => "N",
                            "DETAIL_URL" => "",
                            "FILTER_NAME" => "",
                            "PAGEN_ID" => "",
                            "ROWS_PER_PAGE" => "",
                            "SORT_FIELD" => "UF_ID",
                            "SORT_ORDER" => "ASC"
                        ],
                        false
                    );?>
                </div>
            </div>
            <? $APPLICATION->IncludeComponent(
                "bitrix:form.result.new", 
                "contacts_callback", 
                [
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_SHADOW" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TIME" => "3600000",
                    "CACHE_TYPE" => "A",
                    "CHAIN_ITEM_LINK" => "",
                    "CHAIN_ITEM_TEXT" => "",
                    "EDIT_URL" => "",
                    "IGNORE_CUSTOM_TEMPLATE" => "N",
                    "LIST_URL" => "",
                    "SEF_MODE" => "N",
                    "SUCCESS_URL" => "",
                    "USE_EXTENDED_ERRORS" => "Y",
                    "VARIABLE_ALIASES" => [
                        "RESULT_ID" => "",
                        "WEB_FORM_ID" => "",
                    ],
                    "WEB_FORM_ID" => "1"
                ],
                false
            ); ?>
        </div>
        <div class="contacts-map__frame">
            <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                    "AREA_FILE_SHOW" => "file", 
                    "AREA_FILE_SUFFIX" => "",
                    "EDIT_TEMPLATE" => "standard.php",
                    "PATH" => "/include/contacts/map.php" 
                )
            );?>
        </div>
    </div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>