<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);

?>
<div class="row">
    <?foreach($arResult['ITEMS'] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $uniqueId = $arItem['ID'].'_'.md5($this->randString().$component->getAction());
        $areaId = $areaIds[$arItem['ID']] = $this->GetEditAreaId($uniqueId);
        $obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId);
        
        $res = CIBlockElement::GetByID($arItem['ID']); 
        $ar_res = $res->GetNext();
        $arItem['DETAIL_PAGE_URL'] = $ar_res['DETAIL_PAGE_URL'];
	
        ?>
        <div class="product__itemList col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="product__item product__mini product__item--detailed" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="product-postpone">
                    <?if($arItem['OFFERS']){
                        $favorite_id = $arItem['OFFERS'][0]['ID'];
                    }else{
                        $favorite_id = $arItem['ID'];
                    }?>
                    <a href="javascript:void(0)" class="add-favorites" data-id="<?=$favorite_id?>"><span class="icon"><i class="icon-heart-outline"></i></span></a>
                </div>
                <div class="product-postpone product-postpone__compare">
                    <a href="javascript:void(0)" data-url="<?=$APPLICATION->GetCurPage()?>" class="add-compare" data-id="<?=$arItem['ID']?>"><span class="icon"><i class="icon-chart"></i></span></a>
                </div>
                <div class="product__labels d-inline-flex flex-column align-items-start">
                    <?if($arItem['PROPERTIES']['HIT']['VALUE']):?>
                        <div class="label label__hit"><?=GetMessage('CATALOG_HIT');?></div>
                    <?endif;?>
                    <?if($arItem['PROPERTIES']['SALE']['VALUE']):?>
                        <div class="label label__action"><?=GetMessage('CATALOG_SALE');?></div>
                    <?endif;?>
                    <?if($arItem['PROPERTIES']['NEW']['VALUE']):?>
                        <div class="label label__new"><?=GetMessage('CATALOG_NEW');?></div>
                    <?endif;?>
                </div>
                <div class="product__thumb">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<?if($arItem['PREVIEW_PICTURE']['SRC']) {?>
							<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
						<?} else {?>
							<img src="/bitrix/templates/prymery.auto/assets/img/no_photo.png" alt="no_photo">
						<?}?>
					</a>
                </div>
                <div class="product__content">
                    <div class="product__title product__title_mini">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                    </div>
					
					<div class="product-count text-secondary">
                        <?if($arItem['CATALOG_QUANTITY']>0):?>
                            <span class="icon quantity-exist"><i class="icon-check-circle"></i></span> Есть в наличии
                        <?else:?>
                            <span class="icon quantity-null"><i class="icon-times"></i></span>Ожидается<?//=GetMessage('CATALOG_NOT_AVAIABLE')?>
                        <?endif;?>
                    </div>
					
                    <?$dynamicArea = new \Bitrix\Main\Page\FrameStatic("RatingBlock_".$arItem['ID']);
                    $dynamicArea->startDynamicArea();
                    $APPLICATION->IncludeComponent(
                        "bitrix:iblock.vote",
                        "element_rating",
                        Array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arItem["IBLOCK_ID"],
                            "ELEMENT_ID" =>$arItem["ID"],
                            "MAX_VOTE" => 5,
                            "VOTE_NAMES" => array(),
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "DISPLAY_AS_RATING" => 'vote_avg'
                        ),
                        false, array('HIDE_ICONS'=> 'Y')
                    );
                    $dynamicArea->finishDynamicArea();?>
                    <div class="product__operation d-flex">
                        <div class="product__price">
                            <?if($arItem['MIN_PRICE']['VALUE_NOVAT']>$arItem['MIN_PRICE']['DISCOUNT_VALUE_NOVAT']):?>
                                <div class="product__price--old"><?=$arItem['MIN_PRICE']['PRINT_VALUE_VAT']?></div>
                            <?endif;?>
                            <div class="product__price--new"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE_VAT']?></div>
                        </div>
                        
                        <?if($arItem['CATALOG_QUANTITY']>0):?>
                            <div class="product__action">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="adp-btn adp-btn--primary has-icon-leftward">
                                    <span class="icon"><i class="prymery-icon icon-shoping-cart"></i></span>
                                </a>
                            </div>
                        <?endif;?>
                    </div>
                    <div class="product-operation--hover">
                        <div class="product__price product__price--lg d-flex">
                            <?if($arItem['MIN_PRICE']['VALUE_NOVAT']>$arItem['MIN_PRICE']['DISCOUNT_VALUE_NOVAT']):?>
                                <div class="product__price--old"><?=$arItem['MIN_PRICE']['PRINT_VALUE_VAT']?></div>
                            <?endif;?>
                            <div class="product__price--new"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE_VAT']?></div>
                        </div>
                        
                        <?if($arItem['CATALOG_QUANTITY']>0):?>
                            <div class="d-flex">
                                <div class="product__action product__action--inline 23" id="<?=$areaId.'_basket_actions'?>">
                                    <a href="<?=SITE_DIR?>ajax/quick_order.php?ELEMENT_ID=<?= $arItem['ID'] ?>&IBLOCK_ID=<?= $arResult['IBLOCK_ID'] ?>" class="ajax-form fancybox.ajax one_click_btn adp-btn adp-btn--primary has-icon-leftward">
                                        <span class="icon"><i class="prymery-icon icon-bolt"></i></span><?=GetMessage('CATALOG_ONE_CLICK');?>
                                    </a>
                                    <a href="javascript:void(0)" id="<?=$areaId.'_buy_link'?>" class="add_btn adp-btn adp-btn--primary has-icon-leftward">
                                        <span class="icon"><i class="prymery-icon icon-shoping-cart"></i></span>
                                    </a>
                                </div>
                            </div>
                        <?endif;?>
                    </div>
                </div>
                <?
                $jsParams = array(
                    'PRODUCT_TYPE' => $arItem['PRODUCT']['TYPE'],
                    'SHOW_ADD_BASKET_BTN' => false,
                    'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                    'SHOW_BUY_BTN' => true,
                    'ADD_TO_BASKET_ACTION' => $arResult['ADD_TO_BASKET_ACTION'],
                    'SHOW_CLOSE_POPUP' => $arResult['SHOW_CLOSE_POPUP'] === 'Y',
                    'PRODUCT' => array(
                        'ID' => $arItem['ID'],
                        'NAME' => $arItem['NAME'],
                        'POPUP_TITLE' => GetMessage('POPUP_TITLE'),
                        'POPUP_BASKET_BTN' => GetMessage('POPUP_BASKET_BTN'),
                        'POPUP_CONTINIE_BTN' => GetMessage('POPUP_CONTINIE_BTN'),
                        'DETAIL_PAGE_URL' => $arItem['DETAIL_PAGE_URL'],
                        'PICT' => $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE'],
                        'CAN_BUY' => $arItem['CAN_BUY'],
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
            </div>
        </div>
        <?/*div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="product__item matchHeight product__item--detailed" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="product-postpone">
                    <?if($arItem['OFFERS']){
                        $favorite_id = $arItem['OFFERS'][0]['ID'];
                    }else{
                        $favorite_id = $arItem['ID'];
                    }?>
                    <a href="javascript:void(0)" class="add-favorites" data-id="<?=$favorite_id?>"><span class="icon"><i class="icon-heart-outline"></i></span></a>
                </div>
                <div class="product-postpone product-postpone__compare">
                    <a href="javascript:void(0)" data-url="<?=$APPLICATION->GetCurPage()?>" class="add-compare" data-id="<?=$arItem['ID']?>"><span class="icon"><i class="icon-chart"></i></span></a>
                </div>
                <div class="product__labels d-flex flex-column align-items-start">
                    <?if($arItem['PROPERTIES']['HIT']['VALUE']):?>
                        <div class="label label--hit"><?=GetMessage('CATALOG_HIT');?></div>
                    <?endif;?>
                    <?if($arItem['PROPERTIES']['SALE']['VALUE']):?>
                        <div class="label label-action"><?=GetMessage('CATALOG_SALE');?></div>
                    <?endif;?>
                    <?if($arItem['PROPERTIES']['NEW']['VALUE']):?>
                        <div class="label label--new"><?=GetMessage('CATALOG_NEW');?></div>
                    <?endif;?>
                </div>
                <div class="product__thumb">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>"></a>
                </div>
                <div class="product__title"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
                <?$dynamicArea = new \Bitrix\Main\Page\FrameStatic("RatingBlock_".$arItem['ID']);
                $dynamicArea->startDynamicArea();
                $APPLICATION->IncludeComponent(
                    "bitrix:iblock.vote",
                    "element_rating",
                    Array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arItem["IBLOCK_ID"],
                        "ELEMENT_ID" =>$arItem["ID"],
                        "MAX_VOTE" => 5,
                        "VOTE_NAMES" => array(),
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "DISPLAY_AS_RATING" => 'vote_avg'
                    ),
                    false, array('HIDE_ICON'=> 'Y')
                );
                $dynamicArea->finishDynamicArea();?>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="product__cur-quantity">
                        <?if($arItem['OFFERS']):?>
                            <?=PRauto::CatalogQuantityShow($arItem['ALL_OFFERS_QUANTITY'])?>
                        <?else:?>
                            <?=PRauto::CatalogQuantityShow($arItem['CATALOG_QUANTITY'])?>
                        <?endif;?>
                    </div>
                    <?if($arItem['PROPERTIES']['ARTICLE']['VALUE']):?>
                        <div class="vendor-code"><?=GetMessage('CATALOG_ARTICLE');?> <?=$arItem['PROPERTIES']['ARTICLE']['VALUE']?></div>
                    <?endif;?>
                </div>

                <div class="product__price d-flex justify-content-between align-items-center">
                    <?if($arItem['OFFERS']):?>
                        <div class="product__price--new"><?=$arItem['MIN_PRICE_NEW_PRINT_VAT']?></div>
                        <?if($arItem['MIN_PRICE_OLD_VAT']>$arItem['MIN_PRICE_NEW_VAT']):?>
                            <div class="product__price--old"><?=$arItem['MIN_PRICE_OLD_PRINT_VAT']?></div>
                        <?endif;?>
                    <?else:?>
                        <div class="product__price--new"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE_VAT']?></div>
                        <?if($arItem['MIN_PRICE']['VALUE_NOVAT']>$arItem['MIN_PRICE']['DISCOUNT_VALUE_NOVAT']):?>
                            <div class="product__price--old"><?=$arItem['MIN_PRICE']['PRINT_VALUE_VAT']?></div>
                        <?endif;?>
                    <?endif;?>
                </div>
                <div id="<?=$areaId.'_basket_actions'?>" class="product__action d-block">
                    <?if($arItem['OFFERS']):?>
                        <?if($arItem['SKU_PROPS']):?>
                            <div class="product__sku">
                                <?foreach ($arItem['SKU_PROPS'] as $prop_code=>$prop):?>
                                    <?if($prop_code!='COLOR'):?>
                                        <div class="product__sku-title"><?=$prop['NAME']?></div>
                                        <div class="product__sku-row">
                                            <?foreach ($prop['VALUE'] as $val):?>
                                                <div class="product__sku-val"><?=$val?></div>
                                            <?endforeach;?>
                                        </div>
                                    <?endif;?>
                                <?endforeach;?>
                            </div>
                        <?endif;?>
                        <div class="d-flex justify-content-between">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="adp-btn adp-btn--primary product__detail-btn">
                                <?=GetMessage('CATALOG_DETAIL_LINK');?>
                            </a>
                        </div>
                    <?else:?>
                        <?if($arItem['CATALOG_CAN_BUY_ZERO']=='Y' || $arItem['CATALOG_QUANTITY']>0):?>
                            <div class="d-flex justify-content-between">
                                <a id="<?=$areaId.'_buy_link'?>" href="javascript:void(0);" class="adp-btn adp-btn--primary"><?=GetMessage('CATALOG_INBASKET');?></a>
                                <div class="adp-quantity quantity-light">
                                    <button class="quantity-controller quantity-minus" type="button"><?=GetMessage('CATALOG_MINUS');?></button>
                                    <input id="<?=$areaId.'_quantity'?>" type="text" value="1" class="quantity__value">
                                    <button class="quantity-controller quantity-plus" type="button"><?=GetMessage('CATALOG_PLUS');?></button>
                                </div>
                            </div>
                        <?else:?>
                            <div class="d-flex justify-content-between">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="adp-btn adp-btn--primary product__detail-btn">
                                    <?=GetMessage('CATALOG_DETAIL_LINK');?>
                                </a>
                            </div>
                        <?endif;?>
                    <?endif;?>
                </div>
            </div>
            <?
            $jsParams = array(
                'PRODUCT_TYPE' => $arItem['PRODUCT']['TYPE'],
                'SHOW_ADD_BASKET_BTN' => false,
                'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                'SHOW_BUY_BTN' => true,
                'ADD_TO_BASKET_ACTION' => $arResult['ADD_TO_BASKET_ACTION'],
                'SHOW_CLOSE_POPUP' => $arResult['SHOW_CLOSE_POPUP'] === 'Y',
                'PRODUCT' => array(
                    'ID' => $arItem['ID'],
                    'NAME' => $arItem['NAME'],
                    'POPUP_TITLE' => GetMessage('POPUP_TITLE'),
                    'POPUP_BASKET_BTN' => GetMessage('POPUP_BASKET_BTN'),
                    'POPUP_CONTINIE_BTN' => GetMessage('POPUP_CONTINIE_BTN'),
                    'DETAIL_PAGE_URL' => $arItem['DETAIL_PAGE_URL'],
                    'PICT' => $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE'],
                    'CAN_BUY' => $arItem['CAN_BUY'],
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
        </div*/?>
    <?endforeach;?>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <?=$arResult["NAV_STRING"]?>
        </div>
    <?endif;?>
</div>