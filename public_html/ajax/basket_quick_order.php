<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?if($_REQUEST['IBLOCK_ID'] && \Bitrix\Main\Loader::includeModule('prymery.auto')):?>
    <?$APPLICATION->IncludeComponent(
        "prymery:quick.order",
        "basketmodal",
        array(
            "BUY_ALL_BASKET" => "N",
            "IBLOCK_ID" => (int)$_REQUEST["IBLOCK_ID_ID"],
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600000",
            "CACHE_GROUPS" => "N",
            "COMPONENT_TEMPLATE" => "basketmodal",
            "IBLOCK_TYPE" => "prymery_content",
            "PROPERTIES" => array(
                0 => "FIO",
                1 => "PHONE",
                2 => "EMAIL",
            ),
            "REQUIRED" => array(
                0 => "FIO",
                1 => "PHONE",
                2 => "EMAIL",
            )
        ),
        false
    );?>
<?endif;?>