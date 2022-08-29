<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("История заказов");
	$_REQUEST["filter_history"] = "Y";
	if(!$USER->isAuthorized()){LocalRedirect(SITE_DIR.'auth');} else {
?>
<?$APPLICATION->IncludeComponent("bitrix:sale.personal.order", "prymery", Array(
	"PROP_1" => "",
		"PROP_3" => "",
		"PROP_2" => "",
		"PROP_4" => "",
		"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
		"HISTORIC_STATUSES" => array(	// Перенести в историю заказы в статусах
			0 => "N",
			1 => "F",
		),
		"SEF_FOLDER" => "/personal/history-of-orders/",	// Каталог ЧПУ (относительно корня сайта)
		"ORDERS_PER_PAGE" => "20",	// Количество заказов на одной странице
		"PATH_TO_PAYMENT" => "/order/payment/",	// Страница подключения платежной системы
		"PATH_TO_BASKET" => "/basket/",	// Страница с корзиной
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SAVE_IN_SESSION" => "Y",	// Сохранять установки фильтра в сессии пользователя
		"NAV_TEMPLATE" => "",	// Имя шаблона для постраничной навигации
		"COMPONENT_TEMPLATE" => ".default",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CUSTOM_SELECT_PROPS" => "",	// Дополнительные свойства инфоблока
		"DETAIL_HIDE_USER_INFO" => array(	// Не показывать в информации о пользователе
			0 => "0",
		),
		"PATH_TO_CATALOG" => "/catalog/",	// Путь к каталогу
		"DISALLOW_CANCEL" => "N",	// Запретить отмену заказа
		"RESTRICT_CHANGE_PAYSYSTEM" => array(	// Запретить смену платежной системы у заказов в статусах
			0 => "0",
		),
		"REFRESH_PRICES" => "N",	// Пересчитывать заказ после смены платежной системы
		"ORDER_DEFAULT_SORT" => "STATUS",	// Сортировка заказов
		"STATUS_COLOR_N" => "green",	// Цвет статуса "Принят, ожидается оплата"
		"STATUS_COLOR_F" => "gray",	// Цвет статуса "Выполнен"
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",	// Цвет отменённых заказов
		"SEF_URL_TEMPLATES" => array(
			"list" => "",
			"detail" => "order_detail.php?ID=#ID#",
			"cancel" => "order_cancel.php?ID=#ID#",
		),
		"VARIABLE_ALIASES" => array(
			"detail" => array(
				"ID" => "ID",
			),
			"cancel" => array(
				"ID" => "ID",
			),
		)
	),
	false
);?>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>