<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<?
global $USER;
if(!$USER->isAuthorized()){
	LocalRedirect(SITE_DIR.'auth/');
}
else{?>
	<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.section", 
	"prymery", 
	array(
		"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
			0 => "0",
		),
		"ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
		"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
		"ACCOUNT_PAYMENT_SELL_TOTAL" => array(
			0 => "100",
			1 => "200",
			2 => "500",
			3 => "1000",
			4 => "5000",
			5 => "",
		),
		"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "N",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_RIGHTS_PRIVATE" => "N",
		"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
		"CUSTOM_PAGES" => "[[\"/personal/personal-data/\",\"Личные данные\",\"icon-personal-data\"],[\"/personal/change-password/\",\"Сменить пароль\",\" icon-password-change\"],[\"/personal/history-of-orders/\",\"История заказов\",\"icon-order-history\"],[\"/contacts/\",\"Контакты \",\"icon-contacts\"],[\"/basket/\",\"Корзина\",\"icon-shoping-cart-outline\"]]",
		"CUSTOM_SELECT_PROPS" => "",
		"NAV_TEMPLATE" => "",
		"ORDER_HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"PATH_TO_BASKET" => "/basket/",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_CONTACT" => "/contacts",
		"PATH_TO_PAYMENT" => "/order/payment/",
		"PER_PAGE" => "20",
		"PROP_1" => "",
		"PROP_2" => "",
		"SAVE_IN_SESSION" => "Y",
		"SEF_FOLDER" => "/personal/",
		"SEF_MODE" => "N",
		"SEND_INFO_PRIVATE" => "N",
		"SET_TITLE" => "N",
		"SHOW_ACCOUNT_COMPONENT" => "Y",
		"SHOW_ACCOUNT_PAGE" => "N",
		"SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
		"SHOW_BASKET_PAGE" => "N",
		"SHOW_CONTACT_PAGE" => "N",
		"SHOW_ORDER_PAGE" => "N",
		"SHOW_PRIVATE_PAGE" => "N",
		"SHOW_PROFILE_PAGE" => "N",
		"SHOW_SUBSCRIBE_PAGE" => "N",
		"USER_PROPERTY_PRIVATE" => "",
		"USE_AJAX_LOCATIONS_PROFILE" => "N",
		"COMPONENT_TEMPLATE" => "prymery",
		"ACCOUNT_PAYMENT_SELL_CURRENCY" => "RUB",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"ORDER_HIDE_USER_INFO" => array(
			0 => "0",
		),
		"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "0",
		),
		"ORDER_DEFAULT_SORT" => "STATUS",
		"ORDER_REFRESH_PRICES" => "N",
		"ORDER_DISALLOW_CANCEL" => "N",
		"ORDERS_PER_PAGE" => "20",
		"PROFILES_PER_PAGE" => "20",
		"MAIN_CHAIN_NAME" => ""
	),
	false
);?>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>