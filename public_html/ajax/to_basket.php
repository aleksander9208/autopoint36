<?
 if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!CModule::IncludeModule("iblock")) {
	$this->AbortResultCache();
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}
if (!CModule::IncludeModule("catalog")) {
	ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}
Add2Basket(
	$_REQUEST['PRICE_ID'],
	$_REQUEST['QUANTITY'],
	array(),
	array()
);

$arJSON["STORE"] = $_REQUEST["STORE"];
ob_start(); ?>

<? $APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line",
	"header",
	array(
		"HIDE_ON_BASKET_PAGES" => "N",
		"PATH_TO_BASKET" => SITE_DIR . "basket/",
		"PATH_TO_ORDER" => SITE_DIR . "order/",
		"PATH_TO_PERSONAL" => SITE_DIR . "personal/",
		"PATH_TO_PROFILE" => SITE_DIR . "personal/",
		"PATH_TO_REGISTER" => SITE_DIR . "login/",
		"POSITION_FIXED" => "N",
		"SHOW_AUTHOR" => "N",
		"SHOW_DELAY" => "N",
		"SHOW_EMPTY_VALUES" => "Y",
		"SHOW_IMAGE" => "Y",
		"SHOW_NOTAVAIL" => "N",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_PERSONAL_LINK" => "N",
		"SHOW_PRICE" => "Y",
		"SHOW_PRODUCTS" => "Y",
		"SHOW_SUBSCRIBE" => "N",
		"SHOW_SUMMARY" => "N",
		"SHOW_TOTAL_PRICE" => "Y",
		"COMPONENT_TEMPLATE" => "header"
	),
	false
); ?>

<? $arJSON["BASKET_HTML"] = ob_get_contents(); ?>
<? ob_end_clean();

echo json_encode($arJSON);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>