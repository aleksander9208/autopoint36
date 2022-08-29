<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Личные данные");
	if(!$USER->isAuthorized()){LocalRedirect(SITE_DIR.'auth');} else {
?>
<?$APPLICATION->IncludeComponent("bitrix:main.profile", "profile", Array(
	"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SEND_INFO" => "N",	// Генерировать почтовое событие
		"CHECK_RIGHTS" => "N",	// Проверять права доступа
		"USER_PROPERTY_NAME" => "",	// Название закладки с доп. свойствами
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => ".default",
		"USER_PROPERTY" => "",	// Показывать доп. свойства
	),
	false
);?>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>