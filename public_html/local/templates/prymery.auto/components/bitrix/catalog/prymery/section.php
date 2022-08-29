<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */

/** @var CBitrixComponent $component */

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);

$isFilter = ($arParams['USE_FILTER'] == 'Y');
if ($isFilter) {
    $arFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
    );
    if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
        $arCurSection = $obCache->GetVars();
    } elseif ($obCache->StartDataCache()) {
        $arCurSection = array();
        if (Loader::includeModule("iblock")) {
            $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

            if (defined("BX_COMP_MANAGED_CACHE")) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                if ($arCurSection = $dbRes->Fetch())
                    $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);

                $CACHE_MANAGER->EndTagCache();
            } else {
                if (!$arCurSection = $dbRes->Fetch())
                    $arCurSection = array();
            }
        }
        $obCache->EndDataCache($arCurSection);
    }
    if (!isset($arCurSection))
        $arCurSection = array();
}
?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <? if ($isFilter): ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-2">
                    <aside class="sidebar">
                        <div class="widget catalog_list">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "catalogLeft",
                            array(
                                "ROOT_MENU_TYPE" => "catalog2",
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "catalog2",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "360000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "COMPONENT_TEMPLATE" => "catalog"
                            ),
                            false
                        );?>
                        </div>
                        <div class="widget bx-sidebar-block">
                            <div class="row">
                                <?
                                $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.smart.filter",
                                    "",
                                    array(
                                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                        "SECTION_ID" => $arCurSection['ID'],
                                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                                        "PRICE_CODE" => $arParams["~PRICE_CODE"],
                                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                        "SAVE_IN_SESSION" => "N",
                                        "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                                        "XML_EXPORT" => "N",
                                        "SECTION_TITLE" => "NAME",
                                        "SECTION_DESCRIPTION" => "DESCRIPTION",
                                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                                        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                        "SEF_MODE" => $arParams["SEF_MODE"],
                                        "SEF_RULE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["smart_filter"],
                                        "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                                        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                                        "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                                    ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                );
                                ?>
                            </div>
                        </div>
                        <section class="widget widget-news hidden-md-down">
                            <?$APPLICATION->IncludeComponent("bitrix:news.list", "AsideNews", Array(
                            "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                            "DISPLAY_NAME" => "Y",	// Выводить название элемента
                            "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                            "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
                            "AJAX_MODE" => "N",	// Включить режим AJAX
                            "IBLOCK_TYPE" => "prymery_content",	// Тип информационного блока (используется только для проверки)
                            "IBLOCK_ID" => PRauto::CIBlock_Id('prymery_content','prymery_articles'),	// Код информационного блока
                            "NEWS_COUNT" => "3",	// Количество новостей на странице
                            "SORT_BY1" => "name",	// Поле для первой сортировки новостей
                            "SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
                            "SORT_BY2" => "name",	// Поле для второй сортировки новостей
                            "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
                            "FILTER_NAME" => "",	// Фильтр
                            "FIELD_CODE" => array(	// Поля
                            0 => "",
                            1 => "",
                            ),
                            "PROPERTY_CODE" => array(	// Свойства
                            0 => "",
                            1 => "",
                            ),
                            "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
                            "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                            "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
                            "ACTIVE_DATE_FORMAT" => "j M Y",	// Формат показа даты
                            "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                            "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
                            "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
                            "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
                            "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
                            "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
                            "PARENT_SECTION" => "",	// ID раздела
                            "PARENT_SECTION_CODE" => "",	// Код раздела
                            "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
                            "CACHE_TYPE" => "A",	// Тип кеширования
                            "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                            "CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
                            "CACHE_GROUPS" => "N",	// Учитывать права доступа
                            "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
                            "DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
                            "PAGER_TITLE" => "",	// Название категорий
                            "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
                            "PAGER_TEMPLATE" => "",	// Шаблон постраничной навигации
                            "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                            "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
                            "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
                            "SET_STATUS_404" => "N",	// Устанавливать статус 404
                            "SHOW_404" => "N",	// Показ специальной страницы
                            "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
                            "PAGER_BASE_LINK" => "",
                            "PAGER_PARAMS_NAME" => "arrPager",
                            "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
                            "AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
                            "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
                            "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
                            "COMPONENT_TEMPLATE" => "MiddleBanner",
                            "STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
                            ),
                            false
                            );?>
                        </section>
                    </aside>
                </div>
            <? endif ?>
            <div class="<? if ($isFilter): ?>col-12 col-sm-12 col-md-12 col-lg-9 col-xl-10<? else: ?>col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12<? endif; ?>">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "prymery", array("START_FROM" => "0", "PATH" => "", "SITE_ID" => "s1", "COMPONENT_TEMPLATE" => "prymery"), false); ?>
                        <h1 class="title text-xl font-medium letter-spacing-md">
                            <? $APPLICATION->ShowTitle(false); ?>
                        </h1>
                    </div>
                    <div class="col-12">
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section.list",
                            "prymery",
                            array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                                "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                                "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                                "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                                "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                                "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                                "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
                            ),
                            $component,
                            array("HIDE_ICONS" => "Y")
                        );

                        if ($arParams["USE_COMPARE"] == "Y") {?>
                            <div style="display: none">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:catalog.compare.list",
                                    "",
                                    array(
                                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                        "NAME" => $arParams["COMPARE_NAME"],
                                        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                                        "COMPARE_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["compare"],
                                        "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action"),
                                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                        'POSITION_FIXED' => isset($arParams['COMPARE_POSITION_FIXED']) ? $arParams['COMPARE_POSITION_FIXED'] : '',
                                        'POSITION' => isset($arParams['COMPARE_POSITION']) ? $arParams['COMPARE_POSITION'] : ''
                                    ),
                                    $component,
                                    array("HIDE_ICONS" => "Y")
                                );?>
                            </div>
                        <?} ?>
                        <div class="product__list">
                            <div class="row">
                                <div class="col-12 col-sm col-md col-lg col-xl order-2 order-sm-1">
                                    <ul class="product__sorting">
                                        <?
                                        $sort_shows = "shows";
                                        $sort_price = "catalog_price_1";
                                        $sort_name = "name";
                                        ?>
                                        <li>
                                            <a class="<?= PRauto::CatalogSort($_REQUEST['order']) . PRauto::CatalogSortActive($_REQUEST['sort'], $sort_shows) ?>"
                                               href="<?= $APPLICATION->GetCurPageParam("sort=" . $sort_shows . "&order=" . PRauto::CatalogSort($_REQUEST['order']), array("sort", "order")); ?>"><?= GetMessage('SORT_SHOWS') ?></a>
                                        </li>
                                        <li>
                                            <a class="<?= PRauto::CatalogSort($_REQUEST['order']) . PRauto::CatalogSortActive($_REQUEST['sort'], $sort_price) ?>"
                                               href="<?= $APPLICATION->GetCurPageParam("sort=" . $sort_price . "&order=" . PRauto::CatalogSort($_REQUEST['order']), array("sort", "order")); ?>"><?= GetMessage('SORT_PRICE') ?></a>
                                        </li>
                                        <li>
                                            <a class="<?= PRauto::CatalogSort($_REQUEST['order']) . PRauto::CatalogSortActive($_REQUEST['sort'], $sort_name) ?>"
                                               href="<?= $APPLICATION->GetCurPageParam("sort=" . $sort_name . "&order=" . PRauto::CatalogSort($_REQUEST['order']), array("sort", "order")); ?>"><?= GetMessage('SORT_NAME') ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-sm-auto col-md-auto col-lg-auto col-xl-auto order-1 order-sm-2">
                                    <ul class="product__viual text-right">
                                        <?
                                        $template_block = 'block';
                                        $template_list = 'list';
                                        $template_table = 'table';
                                        ?>
                                        <li>
                                            <a href="<?=SITE_DIR?>basket/#delay"><span class="icon"><i class="icon-heart-outline"></i></span></a>
                                        </li>
                                        <li>
                                            <a href="<?=SITE_DIR?>catalog/compare.php"><span class="icon"><i class="icon-chart"></i></span></a>
                                        </li>
                                        <li>
                                            <a class="<?= PRauto::CatalogSortActive($_REQUEST['display'], $template_block) ?>"
                                               href="<?= $APPLICATION->GetCurPageParam("display=" . $template_block, array("display")); ?>">
                                                <span class="icon"><i class="icon-menu-square"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="<?= PRauto::CatalogSortActive($_REQUEST['display'], $template_list) ?>"
                                               href="<?= $APPLICATION->GetCurPageParam("display=" . $template_list, array("display")); ?>">
                                                <span class="icon"><i class="icon-th-list"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="<?= PRauto::CatalogSortActive($_REQUEST['display'], $template_table) ?>"
                                               href="<?= $APPLICATION->GetCurPageParam("display=" . $template_table, array("display")); ?>">
                                                <span class="icon"><i class="icon-bars"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?
                            $template = 'block';
                            if ($_REQUEST['sort']) {
                                $arParams["ELEMENT_SORT_FIELD"] = $_REQUEST['sort'];
                                $arParams["ELEMENT_SORT_ORDER"] = $_REQUEST['order'];
                            }
                            if ($_REQUEST['display']) {
                                $template = $_REQUEST['display'];
                            }
                            $intSectionID = $APPLICATION->IncludeComponent(
                                "bitrix:catalog.section",
                                $template,
                                array(
                                    "AJAX_MODE" => "Y",
                                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                    "ELEMENT_SORT_FIELD" => 'name',
                                    "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                                    //"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                                    "ELEMENT_SORT_FIELD2" => 'name',
                                    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                                    "PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
                                    "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                                    "BASKET_URL" => $arParams["BASKET_URL"],
                                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                    "SET_TITLE" => $arParams["SET_TITLE"],
                                    "MESSAGE_404" => $arParams["~MESSAGE_404"],
                                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                                    "SHOW_404" => $arParams["SHOW_404"],
                                    "FILE_404" => $arParams["FILE_404"],
                                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                                    "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                                    "PRICE_CODE" => $arParams["~PRICE_CODE"],
                                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                                    "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

                                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                                    "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                                    "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                                    "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

                                    "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
                                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                                    "OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
                                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                                    "OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

                                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                                    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                                    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                                    "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                                    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                                    'LABEL_PROP' => $arParams['LABEL_PROP'],
                                    'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                                    'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                                    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                                    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                                    'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                                    'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                                    'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                                    'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                                    'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                                    'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                                    'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                                    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                                    'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
                                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                                    'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                                    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                                    'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                                    'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                                    'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                                    'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                                    'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                                    'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                                    'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                                    'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                                    'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                                    'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                                    'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                                    'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                                    'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                                    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                                    "ADD_SECTIONS_CHAIN" => "N",
                                    'ADD_TO_BASKET_ACTION' => "",
                                    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                                    'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
                                    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                                    'USE_COMPARE_LIST' => 'Y',
                                    'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                                    'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                                    'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                                ),
                                $component
                            );
                            ?>
                        </div>
                        <?
                        $GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;

                        if (ModuleManager::isModuleInstalled("sale")) {
                            if (!empty($arRecomData)) {
                                if (!isset($arParams['USE_BIG_DATA']) || $arParams['USE_BIG_DATA'] != 'N') {
                                    ?>
                                    <div class="col-xs-12" data-entity="parent-container">
                                        <div class="catalog-block-header" data-entity="header" data-showed="false"
                                             style="display: none; opacity: 0;">
                                            <?= GetMessage('CATALOG_PERSONAL_RECOM') ?>
                                        </div>
                                        <?
                                        $APPLICATION->IncludeComponent(
                                            "bitrix:catalog.section",
                                            "",
                                            array(
                                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                                                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                                                "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                                                "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                                                "PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
                                                "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                                                "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                                                "BASKET_URL" => $arParams["BASKET_URL"],
                                                "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                                                "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                                "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                                                "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                                                "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                                "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                                                "PAGE_ELEMENT_COUNT" => 0,
                                                "PRICE_CODE" => $arParams["~PRICE_CODE"],
                                                "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                                                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                                                "SET_BROWSER_TITLE" => "N",
                                                "SET_META_KEYWORDS" => "N",
                                                "SET_META_DESCRIPTION" => "N",
                                                "SET_LAST_MODIFIED" => "N",
                                                "ADD_SECTIONS_CHAIN" => "N",

                                                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                                                "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                                                "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                                                "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                                                "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

                                                "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
                                                "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                                                "OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
                                                "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                                                "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                                                "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                                                "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                                                "OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

                                                "SECTION_ID" => $intSectionID,
                                                "SECTION_CODE" => "",
                                                "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                                                "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                                                "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                                                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                                                'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                                                'LABEL_PROP' => $arParams['LABEL_PROP'],
                                                'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                                                'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                                                'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                                                'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                                                'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                                                'PRODUCT_ROW_VARIANTS' => "[{'VARIANT':'3','BIG_DATA':true}]",
                                                'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                                                'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                                                'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                                                'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                                                'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                                                "DISPLAY_TOP_PAGER" => 'N',
                                                "DISPLAY_BOTTOM_PAGER" => 'N',
                                                "HIDE_SECTION_DESCRIPTION" => "Y",

                                                "RCM_TYPE" => isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : '',
                                                "SHOW_FROM_SECTION" => 'Y',

                                                'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                                                'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
                                                'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                                                'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                                                'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                                                'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                                                'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                                                'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                                                'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                                                'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                                                'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                                                'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                                                'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                                                'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                                                'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                                                'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                                                'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                                                'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                                                'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                                                'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                                                'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                                                'ADD_TO_BASKET_ACTION' => "",
                                                'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                                                'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
                                                'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                                                'USE_COMPARE_LIST' => 'Y',
                                                'BACKGROUND_IMAGE' => '',
                                                'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                                            ),
                                            $component
                                        );
                                        ?>
                                    </div>
                                    <?
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

