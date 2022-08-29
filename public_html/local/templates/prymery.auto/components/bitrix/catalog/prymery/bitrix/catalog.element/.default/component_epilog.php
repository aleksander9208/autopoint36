<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/swiper.min.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/swiper.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/productItem.js");
PRauto::UpdateCompare();
PRauto::UpdateDelayProduct();
?>

<div id="ask_tab_content" class="hidden">
    <? $APPLICATION->IncludeComponent(
        "bitrix:form.result.new",
        "static",
        array(
            "SEF_MODE" => "N",
            "WEB_FORM_ID" => "ASK_PRODUCT",
            "LIST_URL" => "",
            "EDIT_URL" => "",
            "SUCCESS_URL" => "",
            "CHAIN_ITEM_TEXT" => "",
            "CHAIN_ITEM_LINK" => "",
            "IGNORE_CUSTOM_TEMPLATE" => "Y",
            "USE_EXTENDED_ERRORS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "SEF_FOLDER" => "/",
            "COMPONENT_TEMPLATE" => "modalForm",
            "VARIABLE_ALIASES" => array(
                "WEB_FORM_ID" => "WEB_FORM_ID",
                "RESULT_ID" => "RESULT_ID",
            )
        ),
        false
    );
    ?>
</div>

<?
if (!empty($templateData['TEMPLATE_LIBRARY']))
{
    $loadCurrency = false;
    if (!empty($templateData['CURRENCIES']))
    {
        $loadCurrency = \Bitrix\Main\Loader::includeModule('currency');
    }

    CJSCore::Init($templateData['TEMPLATE_LIBRARY']);

    if ($loadCurrency)
    {
        ?>
        <script>
            BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
        </script>
        <?
    }
}