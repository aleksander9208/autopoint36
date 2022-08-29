<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc,
	\Bitrix\Main\Loader,
	\Bitrix\Highloadblock as HL;
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
$currencyList = '';
if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);
} else {
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$arParams['ADD_TO_BASKET_ACTION'][] = 'ADD';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');
?>
    <div class="row" id="<?= $itemIds['ID'] ?>">
        <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
            <div class="product-detail__labels">
                <? if ($arResult['PROPERTIES']['HIT']['VALUE']): ?>
                    <div class="label label__hit"><?= GetMessage('CATALOG_HIT'); ?></div>
                <? endif; ?>
                <? if ($arResult['PROPERTIES']['SALE']['VALUE']): ?>
                    <div class="label label__action"><?= GetMessage('CATALOG_SALE'); ?></div>
                <? endif; ?>
                <? if ($arResult['PROPERTIES']['NEW']['VALUE']): ?>
                    <div class="label label__new"><?= GetMessage('CATALOG_NEW'); ?></div>
                <? endif; ?>
            </div>
            <div class="product-detail__thumb">
                <div class="swiper-container gallery-top"<? if (!$arResult['PHOTOS']): ?> style="width:100%;"<?endif;?>>
                    <div class="swiper-wrapper">
                        <? if ($arResult['DETAIL_PICTURE']['RESIZE']['BIG']['src']): ?>
                            <div class="slide swiper-slide">
                                <a class="fancybox" rel="detailpicture" href="<?=$arResult['DETAIL_PICTURE']['RESIZE']['REAL']?>">
                                    <img src="<?= $arResult['DETAIL_PICTURE']['RESIZE']['BIG']['src'] ?>"
                                         alt="<?= $arResult['NAME'] ?>">
                                </a>
                            </div>
                        <? endif; ?>
                        <? if ($arResult['PHOTOS']): ?>
                            <? foreach ($arResult['PHOTOS'] as $photo): ?>
                                <div class="slide swiper-slide">
                                    <a class="fancybox" rel="detailpicture" href="<?=$photo['REAL']?>">
                                        <img src="<?= $photo['BIG']['src'] ?>" alt="<?= $photo['DESCRIPTION'] ?>">
                                    </a>
                                </div>
                            <? endforeach; ?>
                        <? endif; ?>
                    </div>
                </div>
                <? if ($arResult['PHOTOS']): ?>
                    <div class="swiper-container gallery-thumbs">
                        <div class="swiper-wrapper">
                            <? if ($arResult['DETAIL_PICTURE']['RESIZE']['SMALL']['src']): ?>
                                <div class="slide swiper-slide">
                                    <img src="<?= $arResult['DETAIL_PICTURE']['RESIZE']['SMALL']['src'] ?>"
                                         alt="<?= $arResult['NAME'] ?>">
                                </div>
                            <? endif; ?>
                            <? if ($arResult['PHOTOS']): ?>
                                <? foreach ($arResult['PHOTOS'] as $photo): ?>
                                    <div class="slide swiper-slide">
                                        <img src="<?= $photo['SMALL']['src'] ?>" alt="<?= $photo['DESCRIPTION'] ?>">
                                    </div>
                                <? endforeach; ?>
                            <? endif; ?>
                        </div>
                    </div>
                <? endif; ?>
                <? if (count($arResult['PHOTOS']) > 3): ?>
                    <div class="thumbs-button-nav thumbs-button-prev"><span class="icon"><i
                                    class="icon-angle-up"></i></span></div>
                    <div class="thumbs-button-nav thumbs-button-next"><span class="icon"><i class="icon-angle-down"></i></span>
                    </div>
                <? endif; ?>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
            <div class="clearfix">
                <?if($arResult['PROPERTIES']['ARTICLE']['VALUE']):?>
                    <div class="product__article"><?=GetMessage('CATALOG_PRODUCT_CODE')?> <?=$arResult['PROPERTIES']['ARTICLE']['VALUE']?></div>
                <?endif;?>
                <? if ($arParams['USE_VOTE_RATING'] === 'Y'): ?>
                    <div id="product__rating" class="product__rating-detail">
                        <? $dynamicArea = new \Bitrix\Main\Page\FrameStatic("productRating_" . $arResult['ID']);
                        $dynamicArea->startDynamicArea();
                        $APPLICATION->IncludeComponent(
                            'bitrix:iblock.vote',
                            'detail',
                            array(
                                'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                'ELEMENT_ID' => $arResult['ID'],
                                'ELEMENT_CODE' => '',
                                'MAX_VOTE' => '5',
                                'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
                                'SET_STATUS_404' => 'N',
                                'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
                                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                'CACHE_TIME' => $arParams['CACHE_TIME']
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        );?>
                        <?$dynamicArea->finishDynamicArea(); ?>
                    </div>
                <? endif; ?>
                <div class="product__like-btns">
                    <div class="product-postpone">
                        <?if($arResult['OFFERS']){
                            $favorite_id = $arResult['OFFERS'][0]['ID'];
                        }else{
                            $favorite_id = $arResult['ID'];
                        }?>
                        <a href="javascript:void(0)" class="add-favorites" data-id="<?=$favorite_id?>"><span class="icon"><i class="icon-heart-outline"></i></span></a>
                    </div>
                    <div class="product-postpone product-postpone__compare">
                        <a href="javascript:void(0)" data-url="<?=$APPLICATION->GetCurPage()?>" class="add-compare" data-id="<?=$arResult['ID']?>"><span class="icon"><i class="icon-chart"></i></span></a>
                    </div>
                </div>
                <?if($arResult['OFFERS']):?>
                    <div class="product__detail-count 1">
                        <?//= $arResult['OFFERS'][0]['CATALOG_QUANTITY'] ?>
                        Ожидается
                    </div>
                <?else:?>
                    <div class="product__detail-count 2">
                       <i class="icon-check-circle"></i> В наличии: <?= $arResult['CATALOG_QUANTITY'] ?>
                    </div>
                <?endif;?>
            </div>
            <?if (in_array('price', $arParams['PRODUCT_PAY_BLOCK_ORDER'])):?>
				<?if($price['PRINT_RATIO_PRICE']):?>
					<div class="product-detail__price font-heavy">
						<div>
							<span id="<?= $itemIds['PRICE_ID'] ?>" data-price="<?= $price['RATIO_PRICE'] ?>"><?= $price['PRINT_RATIO_PRICE'] ?></span>
							<span>/</span>
							<span class="adp-quantity__measure" id="<?= $itemIds['QUANTITY_MEASURE'] ?>">
								<?= $actualItem['ITEM_MEASURE']['TITLE'] ?>
							</span>
						</div>
						<? if ($arParams['SHOW_OLD_PRICE'] === 'Y'): ?>
							<div class="product__price--old product__detail-oldprice" id="<?= $itemIds['OLD_PRICE_ID'] ?>"
								 style="<?= ($showDiscount ? '' : 'display:none;') ?>;">
								<?= ($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '') ?>
							</div>
						<?endif;?>
					</div>
				<?endif;?>
            <?endif;?>
            <div class="product-detail__characteristics">
                                <?if($arResult['PROPERTIES']['TIP_KLAPANA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TIP_KLAPANA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TIP_KLAPANA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VNUTRENNYAYA_REZBA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VNUTRENNYAYA_REZBA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VNUTRENNYAYA_REZBA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DOPOLNITELNYY_ARTIKUL_DOP_INFORMATSIYA_2']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DOPOLNITELNYY_ARTIKUL_DOP_INFORMATSIYA_2']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DOPOLNITELNYY_ARTIKUL_DOP_INFORMATSIYA_2']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SHIRINA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SHIRINA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SHIRINA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TIP_REZBY']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TIP_REZBY']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TIP_REZBY']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DIAMETR_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DIAMETR_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DIAMETR_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SHIRINA_SM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SHIRINA_SM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SHIRINA_SM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VID_EKSPLUATATSII']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VID_EKSPLUATATSII']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VID_EKSPLUATATSII']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DAVLENIE_OTKRYTIYA_OBGONNOGO_KLAPANA_BAR']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DAVLENIE_OTKRYTIYA_OBGONNOGO_KLAPANA_BAR']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DAVLENIE_OTKRYTIYA_OBGONNOGO_KLAPANA_BAR']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['MATERIAL']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['MATERIAL']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['MATERIAL']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['ZASHCHITNYY_MATERIAL_LISTOVOY_METALL']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['ZASHCHITNYY_MATERIAL_LISTOVOY_METALL']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['ZASHCHITNYY_MATERIAL_LISTOVOY_METALL']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DAVLENIE_BAR']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DAVLENIE_BAR']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DAVLENIE_BAR']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CML2_ARTICLE']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['CML2_ATTRIBUTES']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CML2_ATTRIBUTES']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CML2_ATTRIBUTES']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?/*if($arResult['PROPERTIES']['CML2_TRAITS']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CML2_TRAITS']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;*/?>
								
								<?if($arResult['PROPERTIES']['CML2_BASE_UNIT']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CML2_BASE_UNIT']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CML2_BASE_UNIT']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['CML2_BAR_CODE']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CML2_BAR_CODE']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CML2_BAR_CODE']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?/*if($arResult['PROPERTIES']['CML2_TAXES']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CML2_TAXES']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CML2_TAXES']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;*/?>
								
								<?if($arResult['PROPERTIES']['CML2_MANUFACTURER']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CML2_MANUFACTURER']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CML2_MANUFACTURER']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SOEDINITELNAYA_REZBA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SOEDINITELNAYA_REZBA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SOEDINITELNAYA_REZBA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['REMONTNAYA_PLOSHCHADKA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['REMONTNAYA_PLOSHCHADKA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['REMONTNAYA_PLOSHCHADKA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['REGULYATOR']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['REGULYATOR']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['REGULYATOR']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
														
								<?if($arResult['PROPERTIES']['KATALOZHNYY_NOMER']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['KATALOZHNYY_NOMER']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
											<?
											$entity      = HL\HighloadBlockTable::compileEntity('KATALOZHNYYNOMER');
											$entityClass = $entity->getDataClass();
											
											$arRecords = $entityClass::getList([
											  'filter' => [
												'UF_XML_ID' => $arResult['PROPERTIES']['KATALOZHNYY_NOMER']['VALUE']
											  ],
											]);

											foreach ($arRecords as $record) {?>
												 <?= $record['UF_NAME'] ?>
											<?}?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TIP_KRUCHENIYA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TIP_KRUCHENIYA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TIP_KRUCHENIYA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['KOLICHESTVO_SOEDINENIY']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['KOLICHESTVO_SOEDINENIY']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['KOLICHESTVO_SOEDINENIY']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['ARTIKUL']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['ARTIKUL']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
										<?	
											echo "<pre style='display: none;' alt='ARTIKUL'>";
											print_r($arResult['PROPERTIES']['ARTIKUL']);
											echo "</pre>";

											$entity      = HL\HighloadBlockTable::compileEntity('ARTIKUL');
											$entityClass = $entity->getDataClass();
											
											$arRecords = $entityClass::getList([
											  'filter' => [
												'UF_XML_ID' => $arResult['PROPERTIES']['ARTIKUL']['VALUE']
											  ],
											]);

											foreach ($arRecords as $record) {?>
												 <?= $record['UF_NAME'] ?>
											<?}?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['ZASHCHITA_OT_PYLI']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['ZASHCHITA_OT_PYLI']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['ZASHCHITA_OT_PYLI']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['PODACHA_TOPLIVA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['PODACHA_TOPLIVA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['PODACHA_TOPLIVA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SHIRINA_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SHIRINA_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SHIRINA_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TEKHNIKA_PODKLYUCHENIYA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TEKHNIKA_PODKLYUCHENIYA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TEKHNIKA_PODKLYUCHENIYA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['RAZMER_REZBY_1']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['RAZMER_REZBY_1']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['RAZMER_REZBY_1']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SHIRINA_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SHIRINA_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SHIRINA_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['ANALOG']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['ANALOG']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['ANALOG']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['CHISLO_OTVERSTIY_V_DISKE_KOLESA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CHISLO_OTVERSTIY_V_DISKE_KOLESA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CHISLO_OTVERSTIY_V_DISKE_KOLESA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['MOMENT_ZATYAZHKI_NM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['MOMENT_ZATYAZHKI_NM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['MOMENT_ZATYAZHKI_NM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								
								<?if($arResult['PROPERTIES']['NARUZHNAYA_REZBA_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NARUZHNAYA_REZBA_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NARUZHNAYA_REZBA_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TOLSHCHINA_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TOLSHCHINA_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TOLSHCHINA_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['PROVEROCHNOE_ZNACHENIE']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['PROVEROCHNOE_ZNACHENIE']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['PROVEROCHNOE_ZNACHENIE']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VNUTRENNYAYA_REZBA_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VNUTRENNYAYA_REZBA_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VNUTRENNYAYA_REZBA_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TOLSHCHINA_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TOLSHCHINA_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TOLSHCHINA_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['KOLICHESTVO_DATCHIKOV_IZNOSA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['KOLICHESTVO_DATCHIKOV_IZNOSA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['KOLICHESTVO_DATCHIKOV_IZNOSA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['NEOBKHODIMOE_KOLICHESTVO']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NEOBKHODIMOE_KOLICHESTVO']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NEOBKHODIMOE_KOLICHESTVO']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['OBSHCHAYA_DLINA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['OBSHCHAYA_DLINA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['OBSHCHAYA_DLINA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VYSOTA_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VYSOTA_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VYSOTA_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VID_AMORTIZATORA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VID_AMORTIZATORA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VID_AMORTIZATORA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DIAMETR_PROKLADKI_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DIAMETR_PROKLADKI_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DIAMETR_PROKLADKI_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DATCHIK_IZNOSA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DATCHIK_IZNOSA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DATCHIK_IZNOSA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SHIRINA_ZEVA_GAECHNOGO_KLYUCHA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SHIRINA_ZEVA_GAECHNOGO_KLYUCHA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SHIRINA_ZEVA_GAECHNOGO_KLYUCHA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TSVET']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TSVET']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TSVET']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DLINA_PREDUPREZHDAYUSHCHEGO_KONTAKTA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DLINA_PREDUPREZHDAYUSHCHEGO_KONTAKTA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DLINA_PREDUPREZHDAYUSHCHEGO_KONTAKTA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SHAG_REZBY_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SHAG_REZBY_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SHAG_REZBY_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['CHISLO_DVEREY']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CHISLO_DVEREY']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CHISLO_DVEREY']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['RAZMER_KONUSA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['RAZMER_KONUSA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['RAZMER_KONUSA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['UGOL_ZATYAZHKI_GRAD_']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['UGOL_ZATYAZHKI_GRAD_']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['UGOL_ZATYAZHKI_GRAD_']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['NOMERA_ARTIKULOV_REKOMENDUEMYKH_KOMPLEKTUYUSHCHIKH']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NOMERA_ARTIKULOV_REKOMENDUEMYKH_KOMPLEKTUYUSHCHIKH']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NOMERA_ARTIKULOV_REKOMENDUEMYKH_KOMPLEKTUYUSHCHIKH']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['CHISLO_OTVERSTIY']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CHISLO_OTVERSTIY']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CHISLO_OTVERSTIY']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TIP_USTANOVKI']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TIP_USTANOVKI']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TIP_USTANOVKI']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								
								<?if($arResult['PROPERTIES']['DIAMETR_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DIAMETR_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DIAMETR_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TORMOZNAYA_KOLODKA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TORMOZNAYA_KOLODKA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TORMOZNAYA_KOLODKA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['NARUZHNAYA_REZBA_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NARUZHNAYA_REZBA_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NARUZHNAYA_REZBA_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['NOMER_PRODUKTSII']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NOMER_PRODUKTSII']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NOMER_PRODUKTSII']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['KHIM_SVOYSTVO']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['KHIM_SVOYSTVO']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['KHIM_SVOYSTVO']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SPOSOB_KREPLENIYA_AMORTIZATORA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SPOSOB_KREPLENIYA_AMORTIZATORA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SPOSOB_KREPLENIYA_AMORTIZATORA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DIAMETR_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DIAMETR_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DIAMETR_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TIP_KONTEYNERA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TIP_KONTEYNERA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TIP_KONTEYNERA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['KOLICHESTVO_NA_OS']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['KOLICHESTVO_NA_OS']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['KOLICHESTVO_NA_OS']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DLINA_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DLINA_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DLINA_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SODERZHANIE']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SODERZHANIE']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SODERZHANIE']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DIAMETR_PORSHNEVOGO_SHTOKA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DIAMETR_PORSHNEVOGO_SHTOKA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DIAMETR_PORSHNEVOGO_SHTOKA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DLINA_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DLINA_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DLINA_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VNUTRENNIY_DIAMETR']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VNUTRENNIY_DIAMETR']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VNUTRENNIY_DIAMETR']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['WVA_NOMER']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['WVA_NOMER']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['WVA_NOMER']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VNESHNIY_DIAMETR_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VNESHNIY_DIAMETR_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VNESHNIY_DIAMETR_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['KOLICHESTVO_TORMOZNYKH_KOLODOK']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['KOLICHESTVO_TORMOZNYKH_KOLODOK']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['KOLICHESTVO_TORMOZNYKH_KOLODOK']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DLINA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DLINA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DLINA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['OGRANICHENIE_PROIZVODITELYA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['OGRANICHENIE_PROIZVODITELYA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['OGRANICHENIE_PROIZVODITELYA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VYSOTA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VYSOTA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VYSOTA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['NARUZHNAYA_SHIRINA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NARUZHNAYA_SHIRINA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NARUZHNAYA_SHIRINA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['ISPOLNENIE_FILTRA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['ISPOLNENIE_FILTRA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['ISPOLNENIE_FILTRA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DLINA_1_DLINA_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DLINA_1_DLINA_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DLINA_1_DLINA_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['UGOL_ZAMKNUTOGO_SOSTOYANIYA_GRADUS']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['UGOL_ZAMKNUTOGO_SOSTOYANIYA_GRADUS']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['UGOL_ZAMKNUTOGO_SOSTOYANIYA_GRADUS']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VID_KOROBKI_PEREDACH']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VID_KOROBKI_PEREDACH']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VID_KOROBKI_PEREDACH']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['PROIZVODITEL']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['PROIZVODITEL']['NAME'] ?></div>
                                        <div class="product-detail__propsValue"><?= $arResult['PROPERTIES']['PROIZVODITEL']['VALUE'] ?>
											<?php /*foreach ($arResult['PROPERTIES']['PROIZVODITEL']['VALUE'] as $record) {?>
													<?= $record ?>
											<? }*/ ?>

											<?php/* if($arResult['PROPERTIES']['PROIZVODITEL']['VALUE']) {?>



											<?php } else { ?>

												<?
												$entity      = HL\HighloadBlockTable::compileEntity('PROIZVODITEL');
												$entityClass = $entity->getDataClass();
	
												$arRecords = $entityClass::getList([
												  'filter' => [
													'UF_XML_ID' => $arResult['PROPERTIES']['PROIZVODITEL']['VALUE']
												  ],
												]);
	
												foreach ($arRecords as $record) {?>
													<?= $record['UF_NAME'] ?>
												<?}?>
											<?php } */?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['RAZMERY_RADIATORA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['RAZMERY_RADIATORA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['RAZMERY_RADIATORA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TECDOC']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TECDOC']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TECDOC']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['OSNASHCHENIE_OBORUDOVANIE']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['OSNASHCHENIE_OBORUDOVANIE']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['OSNASHCHENIE_OBORUDOVANIE']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TORMOZNAYA_DINAMIKA_DINAMIKA_DVIZHENIYA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TORMOZNAYA_DINAMIKA_DINAMIKA_DVIZHENIYA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TORMOZNAYA_DINAMIKA_DINAMIKA_DVIZHENIYA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VNESHNYAYA_REZBA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VNESHNYAYA_REZBA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VNESHNYAYA_REZBA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SOBLYUDAT_SERVISNUYU_INFORMATSIYU']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SOBLYUDAT_SERVISNUYU_INFORMATSIYU']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SOBLYUDAT_SERVISNUYU_INFORMATSIYU']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SVECHA_ZAZHIGANIYA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SVECHA_ZAZHIGANIYA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SVECHA_ZAZHIGANIYA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['NOMER_REKOMENDUEMOGO_SPETSIALNOGO_INSTRUMENTA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NOMER_REKOMENDUEMOGO_SPETSIALNOGO_INSTRUMENTA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NOMER_REKOMENDUEMOGO_SPETSIALNOGO_INSTRUMENTA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DLINA_REZBY_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DLINA_REZBY_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DLINA_REZBY_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['AVTOMOBIL_S_LEVO_PRAVOSTORONNIM_RASPOLOZHENIEM_']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['AVTOMOBIL_S_LEVO_PRAVOSTORONNIM_RASPOLOZHENIEM_']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['AVTOMOBIL_S_LEVO_PRAVOSTORONNIM_RASPOLOZHENIEM_']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['ZAZOR_MEZHDU_ELEKTRODAMI_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['ZAZOR_MEZHDU_ELEKTRODAMI_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['ZAZOR_MEZHDU_ELEKTRODAMI_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['KOLICHESTVO']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['KOLICHESTVO']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['KOLICHESTVO']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VES_KG']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VES_KG']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VES_KG']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['STORONA_USTANOVKI']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['STORONA_USTANOVKI']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['STORONA_USTANOVKI']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['KOLICHESTVO_REBER']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['KOLICHESTVO_REBER']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['KOLICHESTVO_REBER']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['STOYKA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['STOYKA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['STOYKA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['MATERIAL_KRYSHKI_GOLOVKI_TSILINDRA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['MATERIAL_KRYSHKI_GOLOVKI_TSILINDRA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['MATERIAL_KRYSHKI_GOLOVKI_TSILINDRA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TOLSHCHINA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TOLSHCHINA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TOLSHCHINA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DLINA_UPAKOVKI_SM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DLINA_UPAKOVKI_SM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DLINA_UPAKOVKI_SM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TORMOZNAYA_SISTEMA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TORMOZNAYA_SISTEMA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TORMOZNAYA_SISTEMA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VYSOTA_UPAKOVKI_SM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VYSOTA_UPAKOVKI_SM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VYSOTA_UPAKOVKI_SM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TIP_KORPUSA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TIP_KORPUSA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TIP_KORPUSA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['OT_MODELNOGO_GODA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['OT_MODELNOGO_GODA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['OT_MODELNOGO_GODA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['FORMA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['FORMA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['FORMA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['PRIVODIMYY_V_DEYSTVIE_AGREGAT']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['PRIVODIMYY_V_DEYSTVIE_AGREGAT']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['PRIVODIMYY_V_DEYSTVIE_AGREGAT']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['_FASKI_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['_FASKI_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['_FASKI_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DLINA_SM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DLINA_SM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DLINA_SM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['_FLANTSA_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['_FLANTSA_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['_FLANTSA_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VYSOTA_SM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VYSOTA_SM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VYSOTA_SM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['ALTERNATIVNYY_REMKOMPLEKT']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['ALTERNATIVNYY_REMKOMPLEKT']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['ALTERNATIVNYY_REMKOMPLEKT']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TIP_KREPLENIYA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TIP_KREPLENIYA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TIP_KREPLENIYA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VES_G']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VES_G']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VES_G']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VPUSKN_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VPUSKN_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VPUSKN_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VYSOTA_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VYSOTA_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VYSOTA_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VYPUSKN_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VYPUSKN_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VYPUSKN_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['DOPOLNITELNYY_ARTIKUL_DOPOLNITELNAYA_INFORMATSIYA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['DOPOLNITELNYY_ARTIKUL_DOPOLNITELNAYA_INFORMATSIYA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['DOPOLNITELNYY_ARTIKUL_DOPOLNITELNAYA_INFORMATSIYA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SISTEMA_AMORTIZATORA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SISTEMA_AMORTIZATORA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SISTEMA_AMORTIZATORA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['NARUZHNYY_DIAMETR_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NARUZHNYY_DIAMETR_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NARUZHNYY_DIAMETR_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['CHISLO_ZUBTSOV']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['CHISLO_ZUBTSOV']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['CHISLO_ZUBTSOV']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['NARUZHNYY_DIAMETR_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['NARUZHNYY_DIAMETR_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['NARUZHNYY_DIAMETR_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['SHIRINA_UPAKOVKI_SM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['SHIRINA_UPAKOVKI_SM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['SHIRINA_UPAKOVKI_SM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VNUTRENNIY_DIAMETR_1_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VNUTRENNIY_DIAMETR_1_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VNUTRENNIY_DIAMETR_1_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['TIP_RULYA']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['TIP_RULYA']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['TIP_RULYA']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								<?if($arResult['PROPERTIES']['VNUTRENNIY_DIAMETR_2_MM']['VALUE']):?>
                                    <div class="product-detail__propsRow">
                                        <div class="product-detail__propsName"><?= $arResult['PROPERTIES']['VNUTRENNIY_DIAMETR_2_MM']['NAME'] ?></div>
                                        <div class="product-detail__propsValue">
                                            <?= $arResult['PROPERTIES']['VNUTRENNIY_DIAMETR_2_MM']['VALUE'] ?>
                                        </div>
                                    </div>
                                <?endif;?>
								
								
                            </div>
            <?  $uniqueId = $arResult['ID'].'_'.md5($this->randString().$component->getAction());
            $areaId = $areaIds[$arResult['ID']] = $this->GetEditAreaId($uniqueId);
            $obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId);
            ?>
            <div class="product-detail__actions d-flex" id="<?= $areaId . '_basket_actions' ?>">
                <?if($arResult['MIN_PRICE']['CAN_BUY']=='Y'):?>
                    <?if($arResult['CATALOG_CAN_BUY_ZERO']=='Y' || $arResult['CATALOG_QUANTITY']>0):?>
                        <div class="product-detail__quantity adp-quantity quantity-light" style="<?= (!$actualItem['CAN_BUY'] ? 'display: none;' : '') ?>" data-entity="quantity-block">
                            <button class="quantity-controller quantity-minus" type="button">-</button>
                            <input data-product="<?=$itemIds['ID']?>" id="<?=$areaId.'_quantity'?>" type="number" value="<?= $price['MIN_QUANTITY'] ?>" class="quantity__value">
                            <button class="quantity-controller quantity-plus" type="button">+</button>
                        </div>
                        <a id="<?= $areaId . '_buy_link' ?>" href="javascript:void(0);"
                           class="adp-btn adp-btn--primary adp-btn--padding-sm mr-15">
                            <?= GetMessage('CATALOG_INBASKET'); ?>
                        </a>
                        <a href="<?=SITE_DIR?>ajax/quick_order.php?ELEMENT_ID=<?= $arResult['ID'] ?>&IBLOCK_ID=<?= $arResult['IBLOCK_ID'] ?>"
                           class="ajax-form fancybox.ajax adp-btn adp-btn--outline-primary adp-btn--padding-sm">
                            <?=GetMessage('CATLOG_ONE_CLICK_BTN')?>
                        </a>
                    <?endif;?>
                <?endif;?>
            </div>
            <div class="product-detail__total product-detail__hidden">
                <?if (in_array('quantity', $arParams['PRODUCT_PAY_BLOCK_ORDER'])):?>
                    <?if ($arParams['USE_PRODUCT_QUANTITY']): ?>
                        <span><?=GetMessage('CATALOG_TOTAL_PRICE')?></span>
                        <span id="<?= $itemIds['ID'].'_price_total' ?>"></span>
                        <?=GetMessage('CATALOG_CURRENCY')?>
                    <?endif;?>
                <?endif;?>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="product-detail__description">
                <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
                    <? if ($arResult['PROPERTIES']['PROPS']['VALUE']): ?>
                        <li class="nav-item">
                            <a class="tabs_link nav-link <? if (!$arResult['PROPERTIES']['PROPS']['VALUE']): ?> active<? endif; ?>" id="options-tab" data-toggle="tab" href="#options" role="tab"
                               aria-controls="options" aria-selected="true">
                                <?=GetMessage('CATALOG_OPTIONS_TAB')?>
                            </a>
                        </li>
                    <? endif; ?>
                    <? if ($arResult['DETAIL_TEXT']): ?>
                        <li class="nav-item">
                            <a class="tabs_link nav-link<? if (!$arResult['PROPERTIES']['PROPS']['VALUE']): ?> active<? endif; ?> 123"
                               id="description-tab" data-toggle="tab" href="#description" role="tab"
                               aria-controls="description" aria-selected="true">
                                <?=GetMessage('CATALOG_DESCRIPTION_TAB')?>
                            </a>
                        </li>
                    <? endif; ?>

                    <? /* ?>
                    <li class="nav-item">
                        <a class="tabs_link nav-link<? if (!$arResult['PROPERTIES']['PROPS']['VALUE'] && !$arResult['DETAIL_TEXT']): ?> active<? endif;?>"
                           id="payment-tab" data-toggle="tab" href="#payment" role="tab"
                           aria-controls="description"
                           aria-selected="true">
                            <?= GetMessage('CATALOG_PAYMENT') ?>
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a class="tabs_link nav-link"
                           id="delivery-tab" data-toggle="tab" href="#delivery" role="tab"
                           aria-controls="description" aria-selected="true">
                            <?= GetMessage('CATALOG_DELIVERY') ?>
                        </a>
                    </li> <? */ ?>
                    <li class="nav-item">
                        <a class="tabs_link nav-link"
                           id="ask-tab"
                           data-toggle="tab" href="#ask" role="tab" aria-controls="description"
                           aria-selected="true">
                            <?=GetMessage('CATALOG_ASK_TAB')?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
					
                    
                        <div class="tab-pane fade show <? if (!$arResult['PROPERTIES']['PROPS']['VALUE'] && !$arResult['DETAIL_TEXT']): ?> show active<?endif;?>" id="options" role="tabpanel"
                             aria-labelledby="description-tab">
                            
                            
                        </div>
                    
                    <? if ($arResult['~DETAIL_TEXT']): ?>
                        <div class="tab-pane fade<? if (!$arResult['PROPERTIES']['PROPS']['VALUE']): ?> show active<?endif;?> 123" id="description" role="tabpanel"
                             aria-labelledby="description-tab">
                            <?= $arResult['~DETAIL_TEXT'] ?>
                        </div>
                    <? endif; ?>
                    <? /* ?>
                    <div class="tab-pane fade<? if (!$arResult['PROPERTIES']['PROPS']['VALUE'] && !$arResult['DETAIL_TEXT']): ?> show active<?endif;?>" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                        <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/ru/payment.php"),Array(),Array("MODE"=>"php"));?>
                    </div>
                    <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                        <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/ru/delivery.php"),Array(),Array("MODE"=>"php"));?>
                    </div>
                    <? */ ?>
                    <div class="tab-pane fade" id="ask" role="tabpanel" aria-labelledby="ask-tab">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?
    $jsParams = array(
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'SHOW_ADD_BASKET_BTN' => false,
        'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
        'SHOW_BUY_BTN' => true,
        'ADD_TO_BASKET_ACTION' => $arResult['ADD_TO_BASKET_ACTION'],
        'SHOW_CLOSE_POPUP' => $arResult['SHOW_CLOSE_POPUP'] === 'Y',
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'NAME' => $arResult['NAME'],
            'POPUP_TITLE' => GetMessage('POPUP_TITLE'),
            'POPUP_BASKET_BTN' => GetMessage('POPUP_BASKET_BTN'),
            'POPUP_CONTINIE_BTN' => GetMessage('POPUP_CONTINIE_BTN'),
            'DETAIL_PAGE_URL' => $arResult['DETAIL_PAGE_URL'],
            'PICT' => $arResult['SECOND_PICT'] ? $arResult['PREVIEW_PICTURE_SECOND'] : $arResult['PREVIEW_PICTURE'],
            'CAN_BUY' => $arResult['CAN_BUY'],
        ),
        'BASKET' => array(
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        ),
        'VISUAL' => array(
            'ID' => $areaId,
            'BUY_ID' => $areaId.'_buy_link',
            'QUANTITY_ID' => $areaId.'_quantity',
            'BASKET_ACTIONS_ID' => $areaId.'_basket_actions',
        )
    );
    ?>
    <script>
        var <?=$obName?> = new JCCatalogItem(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>
<?unset($actualItem, $itemIds, $jsParams);?>