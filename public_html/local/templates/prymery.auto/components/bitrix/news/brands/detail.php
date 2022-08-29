<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>

<?$ElementID = $APPLICATION->IncludeComponent(
	"bitrix:news.detail",
	"",
	Array(
		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
		"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"META_KEYWORDS" => $arParams["META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
		"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
		"ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
		"DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
		"PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
		"USE_SHARE" => $arParams["USE_SHARE"],
		"SHARE_HIDE" => $arParams["SHARE_HIDE"],
		"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
		"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
		"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
		"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
		"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
		'STRICT_SECTION_CHECK' => (isset($arParams['STRICT_SECTION_CHECK']) ? $arParams['STRICT_SECTION_CHECK'] : ''),
	),
	$component
);

global $arBrand;
require_once "arParams__calatog_section.php";
$arParams = $arParamsCatSect;


if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');

if ($isFilter)
{
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

	
}

?>




<div class="page-root__content">
    <div class="content">
        <div class="content__inner">
          <?
          $APPLICATION->IncludeComponent("bitrix:breadcrumb", "blog", Array(
            "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
            "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
            "SITE_ID" => "-",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
          ),
            false
          );
          ?>

            <div class="catalog-page">
                <div class="catalog-page__wrap wrap_l wrap_center">
                    <div class="catalog-page__left">
                        <div class="catalog-page__left-wrap">
                            <div class="catalog-page__left-catlist">
                                <div class="catlist">
								    <?
                                          $arParams["SEF_FOLDER"] = '/catalog/';
                                          $arUrlTemplates = [
                                            'sections' => '',
                                            'section' => '#SECTION_CODE#/',
                                            'element' => '#SECTION_CODE#/#ELEMENT_CODE#.html',
                                            'compare' => 'compare/',
                                          ];
                                          $componentPage = CComponentEngine::ParseComponentPath(
                                            $arParams["SEF_FOLDER"],
                                            $arUrlTemplates,
                                            $SEF
                                          );

                                          $SEC = xTools::GetIBlockSectionByCode($SEF['SECTION_CODE'],
                                            CATALOG_IBLOCK_ID);
											
										$arSectSelect = array("ID", "NAME", "SECTION_PAGE_URL", "UF_*");
										$arSectSelect = array();
										$arSectFilter = array('IBLOCK_ID' => CATALOG_IBLOCK_ID, "UF_VIEWED" => false);
										$rsSect = CIBlockSection::GetList(array('NAME' => 'ASC'), $arSectFilter, false, 	$arSectSelect);
									   
										$arSections = array();
									   
										while ($arItemSect = $rsSect->GetNext())
											$arSections[] = $arItemSect;
										
										
										$arElemFilter = array(
											"IBLOCK_ID" => $arParams["IBLOCK_ID"],
											"CATALOG_AVAILABLE" => "Y",
											"ACTIVE" => "Y"
										);
										$arElemSelect = array("ID", "NAME", "CODE", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID");
										$arElements = array();
									   	
										$res = CIBlockElement::GetList(Array(), $arElemFilter, false, false, $arElemSelect);
										while($ob = $res->GetNextElement())
										{
											$arFields = $ob->GetFields();
											$sectionId = $arFields["IBLOCK_SECTION_ID"];
											$arElements[$sectionId][] = $arFields;
										} // while
									   
									   
									 if (count($arSections)){?>
									
                                    <div class="catlist__wrap">
                                        <div class="catlist__title">
                                            <p>Тип продукта</p>
                                            <div class="plus-button"></div>
                                        </div>
                                        <div class="catlist__list">
                                        
										<?foreach ($arSections as $arItemSect) { 
											// Исключаем пустые разделы
											$sectionId = $arItemSect["ID"];
											if(!count($arElements[$sectionId])) continue;
										?>
                                            <a href="<?= $arItemSect['SECTION_PAGE_URL'] ?>" class="catlist__item"><?=$arItemSect['NAME']?></a>
										<? } // foreach ?>
										
                                        </div>
                                    </div>
                                         <?} // if ?>
                                            
                                </div>
                            </div>
							
							<? if ($isFilter || $isSidebar): ?>
                            <?
                            $APPLICATION->IncludeComponent(
                              "bitrix:catalog.smart.filter",
                              "",
                              array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "SECTION_ID" => $arCurSection['ID'],
                                "FILTER_NAME" => $arParams["FILTER_NAME"],
                                "PRICE_CODE" => $arParams["PRICE_CODE"],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "SAVE_IN_SESSION" => "N",
                                "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                                "XML_EXPORT" => "N",
                                "DISPLAY_ELEMENT_COUNT " => "Y",
                                "SECTION_TITLE" => "NAME",
                                "SECTION_DESCRIPTION" => "DESCRIPTION",
                                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                "SEF_MODE" => $arParams["SEF_MODE"],
                                "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                                "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                                "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                              ),
                              $component,
                              array('HIDE_ICONS' => 'Y')
                            );



                            ?>

                          <?endif?>
						  
							<?php 
							$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE","PROPERTY_*");
							$arFilter = Array("IBLOCK_ID" => 23, "ACTIVE" => "Y", "PROPERTY_CAT_SECTION" => $SEC["ID"]);
							$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
							$arBanners = array();
							
							while($ob = $res->GetNextElement()){ 
								$arFields = $ob->GetFields(); 								
								$arProps = $ob->GetProperties();
								
								$arBanners[] = array(
									"arFields" => $arFields,
									"arProps" => $arProps,
								);
							} // while
							
							if(!count($arBanners)){
								
								$arFilter["PROPERTY_CAT_SECTION"] = false;
								$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
								
								while($ob = $res->GetNextElement()){ 
									$arFields = $ob->GetFields(); 								
									$arProps = $ob->GetProperties();
									
									$arBanners[] = array(
										"arFields" => $arFields,
										"arProps" => $arProps,
									);
								} // while
							} // if
							
							
								// if($SEC["DETAIL_PICTURE"])
									// $bannerSection = CFile::GetPath($SEC["DETAIL_PICTURE"]);
								// else
									// $bannerSection = SITE_TEMPLATE_PATH . "/img/vr/action1.png";
								
								
								// если ширина меньше 850 пикселей
								// /img/vr/action1-cat.png
								
							?>
                         
                            <div class="catalog-page__left-actions">
								<?php foreach($arBanners as $banner){
								$bannerSrc = CFile::GetPath($banner["arFields"]["PREVIEW_PICTURE"]);
								$bannerUrl = $banner["arProps"]["LINK"]["VALUE"];
								
								if(!$bannerUrl) $bannerUrl = "#";
							?>
                                <div class="catalog-page__action">
                                    <a href="<?= $bannerUrl ?>">
                                        <picture>
                                            <!-- если ширина меньше 850 пикселей -->
                                            <source srcset="<?= $bannerSrc ?>" media="(max-width: 850px)" />
                                            <!-- если ширина больше 850 пикселей (по умолчанию) -->
                                            <img src="<?= $bannerSrc ?>" alt="" />
                                        </picture>
                                    </a>
                                </div>
							<?php } // foreach ?>
                            </div>
                        </div>
                    </div>
					
                    <?

                    if ($Req['sort']=='price')  $sort=['PROPERTY_PRICE','ASC'];
                    if ($Req['sort']=='name')  $sort=['NAME','ASC'];
                    if ($Req['sort']=='rating')  $sort=['PROPERTY_RATING','ASC'];


                    if ($sort) {
                      $arParams["ELEMENT_SORT_FIELD"] = $sort[0];
                      $arParams["ELEMENT_SORT_ORDER"] = $sort[1];
                    }

					
					$sectionName = $SEC["NAME"] ? $SEC["NAME"] : "Каталог продукции";
					
                    ?>
					
                    <div class="catalog-page__right">
                        <div class="catalog-page__right-wrap">
                            <div class="catalog-page__title">
                                <h1>Продукция от производителя <?= ucfirst($arBrand["NAME"]) ?></h1>
                            </div>
                            <div class="catalog-page__catwrap">
                                <div class="catalog-page__sort">
                                    <div class="drop-list drop-list_dis-ib">
                                        <p class="drop-list__title">Сортировать по цене &uarr;</p>
                                        <input class="drop-list__input listener-changes result-value" name="sort" value="price" type="hidden">
                                        <div class="drop-list__list drop-list_dis-ib">
                                            <ul class="d-list d-list_shadow">
                                                <li class="d-list__one">
                                                    <a href="#" data-value="price" data-direction="asc">Сортировать по цене &uarr;</a>
                                                </li>
												 <li class="d-list__one">
                                                    <a href="#" data-value="price" data-direction="desc">Сортировать по цене &darr;</a>
                                                </li>
												
                                                <li class="d-list__one">
                                                    <a href="#" data-value="name" data-direction="asc">Сортировать по названию &uarr;</a>
                                                </li>
												<li class="d-list__one">
                                                    <a href="#" data-value="name" data-direction="desc">Сортировать по названию &darr;</a>
                                                </li>
												
                                                <li class="d-list__one">
                                                    <a href="#" data-value="rating" data-direction="asc">Сортировать по рейтингу &uarr;</a>
                                                </li>
												<li class="d-list__one">
                                                    <a href="#" data-value="rating" data-direction="desc">Сортировать по рейтингу &darr;</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="catalog-page__view">
                                    <div class="view">
                                        <select class="view__select result-value" name="view">
                                            <option value="tile"></option>
                                            <option value="list"></option>
                                        </select>
                                        <div class="view__one active">
                                            <div class="view__item view__item_tile" data-view="tile"></div>
                                        </div>
                                        <div class="view__one">
                                            <div class="view__item view__item_list" data-view="list"></div>
                                        </div>
                                    </div>
                                </div>
                                <?
								
								global $arrFilterBrand;
								
								if ($_SERVER['REMOTE_ADDR'] == '217.25.227.230'){
									echo "<pre style='display: none;' alt='NAME'>";
									print_r($arBrand["NAME"]);
									echo "</pre>";
									
									echo "<pre style='display: none;' alt='PROPERTY_CML2_MANUFACTURER_VALUE'>";
									print_r($arrFilterBrand);
									echo "</pre>";
								} // if
								
								// if ($arBrand["NAME"] == 'Спортивные технологии') {
									// $arrFilterBrand["PROPERTY_CML2_MANUFACTURER_VALUE"] = $arBrand["NAME"];
								// } else {
									$arrFilterBrand["PROPERTY_CML2_MANUFACTURER_VALUE"] = $arBrand["NAME"];
								// }
								
								

                                // взял с цума, а то что ниже оригинал XC
                                $intSectionID = $APPLICATION->IncludeComponent(
                                  "bitrix:catalog.section",
                                  "",
                                  array(
                                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                    "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                                    "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                                    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                                    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                                    "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                                    "INCLUDE_SUBSECTIONS" => $arCurSection2?'Y':$arParams["INCLUDE_SUBSECTIONS"],
                                    "BASKET_URL" => $arParams["BASKET_URL"],
                                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                                    // "FILTER_NAME" => $arParams["FILTER_NAME"],
                                    "FILTER_NAME" => "arrFilterBrand",
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
                                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                                    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

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

                                    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                                    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                                    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                                    "SECTION_ID" => $arCurSection['ID'],////$arResult["VARIABLES"]["SECTION_ID"],
                                    "SECTION_CODE" => '',//$arResult["VARIABLES"]["SECTION_CODE"],
                                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                                    "DETAIL_URL" => '/catalog/#SECTION_CODE#/#ELEMENT_CODE#/',//$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
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
                                    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
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
                                    "ADD_SECTIONS_CHAIN" => "Y",
                                    'ADD_TO_BASKET_ACTION' => $basketAction,
                                    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                                    'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                                    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                                    'SHOW_ALL_WO_SECTION' => 'Y',
                                    'USE_COMPARE_LIST' => 'Y',
                                    'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                                    'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                                    'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                                  ),
                                  $component
                                );



                                ?>

                            </div>
							
                            <?/* <!-- если по фильтрам нет результатов --> */?>
                            <div class="sistem-block">
                                <div class="sistem-block__img --cat_empty"></div>
                                <div class="sistem-block__text">
                                    <div class="text">
                                        <p>К сожалению, ничего не найдено. Попробуйте поменять фильтры, и товары обязательно найдутся.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="catalog-page__section-text">
                                <div class="notes-text">
                                    <div class="notes-text__text text">
                                      <?$APPLICATION->ShowViewContent('SECTION_DESCRIPTION');?>
                                    </div>
                                    <?
                                    if (strlen($APPLICATION->GetViewContent('SECTION_DESCRIPTION'))>450){
                                    ?>
                                    <div class="notes-text__button">Показать</div>
                                    <?}?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<div id="pageLoad" class="page-load">
    <div class="page-load__wrap"></div>
</div>











