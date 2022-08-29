<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile(__FILE__);
global $APPLICATION;

use Bitrix\Main\Page\Asset;

$bIncludedModule = (\Bitrix\Main\Loader::includeModule("prymery.auto")); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><? $APPLICATION->ShowTitle() ?></title>
    <link rel="icon" type="image/x-icon" href="/favicon.png" >
    
    <? $APPLICATION->ShowMeta("viewport");
    
    
    
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/bootstrap-grid.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/fonts.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/prymery-icons.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/js/fancybox/jquery.fancybox.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/owl.carousel.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/style.min.css");

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery-3.3.1.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/css-vars-polyfill.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/fancybox/jquery.fancybox.pack.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/bootstrap.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery.matchHeight.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/owl.carousel.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/main.js");

    $GLOBALS["PAGE"] = explode("/", $APPLICATION->GetCurPage());
    $APPLICATION->ShowHead();
    if($bIncludedModule){
        PRauto::BaseColor();
    } ?>
</head>
<body<?if($GLOBALS['PAGE'][1] && '/'.$GLOBALS['PAGE'][1].'/' != SITE_DIR || $GLOBALS['PAGE'][2]):?> class="home"<?endif;?>>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<? if (!$bIncludedModule): ?>
<? $APPLICATION->SetTitle(GetMessage("ERROR_INCLUDE_MODULE_PRYMERY_AUTO_TITLE")); ?>
<center><? $APPLICATION->IncludeFile(SITE_DIR . "include/error_include_module.php"); ?></center>
</body>
</html>
<? die(); ?>
<? endif; ?>
<header class="main-header">
    <div class="main-header__top">
        <div class="container">
            <div class="row justify-content-between justify-content-lg-end">
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3 offset-xl-1 hidden-md-down">
                    <div class="header-social">
                        <?= PRauto::DisplaySocial(); ?>
                    </div>
                </div>

                <div class="col-12 col-sm-auto col-md-auto col-lg-6 col-xl-3 offset-lg-2">
                    <div class="header-links header-contacts">
                        <ul>
                            <li><?= PRauto::DisplayEmail(); ?></li>
                            <li><?= PRauto::DisplayPhone(); ?></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-sm-auto col-md-auto col-lg-6 col-xl-3">
                    <div class="header-links header-cabinet">
                        <ul>
                            <?global $USER;
                            if($USER->IsAuthorized()):?>
                                <li><a href="<?=SITE_DIR?>personal/">Личный кабинет</a></li>
                                <li><a href="<?=$APPLICATION->GetCurPage();?>?logout=yes" title="<?=GetMessage('LOGOUT_TITLE')?>"><?=GetMessage('LOGOUT_TITLE')?></a></li>
                            <?else:?>
                                <li><a href="<?=SITE_DIR?>auth/" title="<?=GetMessage('HEADER_AUTH_TITLE')?>"><?=GetMessage('HEADER_AUTH_TITLE')?></a></li>
                                <li><a href="<?=SITE_DIR?>auth/?register=yes" title="<?=GetMessage('REGISTRATION_TITLE')?>"><?=GetMessage('REGISTRATION_TITLE')?></a></li>
                            <?endif;?>
                        </ul>
                        <div class="toggle-menu">
                            <button><em></em><em></em><em></em></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-header__middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <?= PRauto::DisplayLogo(); ?>
                </div>

                <div class="col-12 col-sm-12 col-md col-lg-4 col-xl-4">
                    <? $APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"header", 
	array(
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "title-search",
		"PRICE_CODE" => array(
			0 => "BASE",
			1 => "RETAIL",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "150",
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"PAGE" => SITE_DIR."catalog/index.php",
		"NUM_CATEGORIES" => "",
		"TOP_COUNT" => "10",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "Y",
		"CHECK_DATES" => "Y",
		"SHOW_OTHERS" => "N",
		"CATEGORY_0_TITLE" => "",
		"CATEGORY_0" => array(
			0 => "no",
		),
		"CATEGORY_0_iblock_news" => array(
			0 => "all",
		),
		"CATEGORY_1_TITLE" => "Форумы",
		"CATEGORY_1" => array(
			0 => "forum",
		),
		"CATEGORY_1_forum" => array(
			0 => "all",
		),
		"CATEGORY_2_TITLE" => "Каталоги",
		"CATEGORY_2" => array(
			0 => "iblock_books",
		),
		"CATEGORY_2_iblock_books" => "all",
		"CATEGORY_OTHERS_TITLE" => "Прочее",
		"COMPONENT_TEMPLATE" => "header",
		"CATEGORY_0_iblock_1c_catalog" => array(
			0 => "8",
		)
	),
	false
); ?>
                </div>

                <div class="col-12 col-sm-12 col-md-auto col-lg-4 col-xl-4">
                    <div class="header-actions d-flex justify-content-center justify-content-md-end">
                        <a href="<?=SITE_DIR?>form/?FORM_ID=CALLBACK" class="ajax-form fancybox.ajax adp-btn adp-btn--outline-primary" title="<?= GetMessage('CALLBACK_TITLE'); ?>">
                            <?= GetMessage('CALLBACK_TITLE'); ?>
                        </a>
                        <? $dynamicArea = new \Bitrix\Main\Page\FrameStatic("HeaderBasket");
                        $dynamicArea->startDynamicArea();
                        $APPLICATION->IncludeComponent(
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
                                "COMPONENT_TEMPLATE" => "header_line"
                            ),
                            false
                        );
                        $dynamicArea->finishDynamicArea();?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-header__bottom<?if($GLOBALS['PAGE'][1] && '/'.$GLOBALS['PAGE'][1].'/' != SITE_DIR):?> nohome<?endif;?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                    <nav class="main-navigation__wrapper">
                        <? $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "top",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "360000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "top"
	),
	false
); ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

<? PRauto::ShowMainWrap(); ?>
