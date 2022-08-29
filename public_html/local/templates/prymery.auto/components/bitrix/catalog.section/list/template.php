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
        ?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="product__item product-display__list" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="product__thumb">
                    <div class="product__labels d-flex flex-column">
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
                    <div class="product-postpone product-postpone__list">
                        <a href="javascript:void(0)" class="add-favorites" data-id="<?=$arItem['ID']?>"><span class="icon"><i class="icon-heart-outline"></i></span></a>
                        <a href="javascript:void(0)" data-url="<?=$APPLICATION->GetCurPage()?>" class="add-compare" data-id="<?=$arItem['ID']?>"><span class="icon"><i class="icon-chart"></i></span></a>
                    </div>
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<?if($arItem['PREVIEW_PICTURE']['SRC']) {?>
							<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
						<?} else {?>
							<img src="/bitrix/templates/prymery.auto/assets/img/no_photo.png" alt="no_photo">
						<?}?>
					</a>
                </div>
                <div class="product__content d-flex flex-column">
                    <div class="product__title 1">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                    </div>
					<div class="product-count text-secondary">
                        <?if($arItem['CATALOG_QUANTITY']>0):?>
                            <span class="icon quantity-exist"><i class="icon-check-circle"></i></span> Есть в наличии
                        <?else:?>
                            <span class="icon quantity-null"><i class="icon-times"></i></span>Ожидается<?//=GetMessage('CATALOG_NOT_AVAIABLE')?>
                        <?endif;?>
                    </div><br>
                    <div class="d-flex align-items-center">
                        <ul class="product__rating rating-stars d-inline-flex">
                            <?$dynamicArea = new \Bitrix\Main\Page\FrameStatic("RatingList_".$arItem['ID']);
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
                        </ul>
                        <?if($arItem['PROPERTIES']['ARTICLE']['VALUE']):?>
                            <div class="vendor-code text-secondary"><?=GetMessage('CATALOG_ARTICLE');?> <?=$arItem['PROPERTIES']['ARTICLE']['VALUE']?></div>
                        <?endif;?>
                    </div>
                    <?if($arItem['PREVIEW_TEXT']):?>
                        <div class="product__description">
                            <?=$arItem['~PREVIEW_TEXT']?>
                        </div>
                    <?endif;?>
                </div>
                <div class="product__evaluation d-flex">
                    <div class="product__price">
                        <?if($arItem['MIN_PRICE']['VALUE_NOVAT']>$arItem['MIN_PRICE']['DISCOUNT_VALUE_NOVAT']):?>
                            <div class="product__price--old"><?=$arItem['MIN_PRICE']['PRINT_VALUE_VAT']?></div>
                        <?endif;?>
                        <div class="product__price--new"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE_VAT']?></div>
                    </div>
                    <div class="product__action" id="<?=$areaId.'_basket_actions'?>">
                        <?if($arItem['CATALOG_CAN_BUY_ZERO']=='Y' || $arItem['CATALOG_QUANTITY']>0):?>
                            <div class="adp-quantity quantity-light">
                                <button class="quantity-controller quantity-minus" type="button">-</button>
                                <input id="<?=$areaId.'_quantity'?>" type="text" value="1" class="quantity__value">
                                <button class="quantity-controller quantity-plus" type="button">+</button>
                            </div>
                            <a href="javascript:void(0);" id="<?=$areaId.'_buy_link'?>" class="adp-btn adp-btn--primary"><?=GetMessage('CATALOG_INBASKET');?></a>
                        <?else:?>
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="adp-btn adp-btn--primary product__detail-btn"><?=GetMessage('CATALOG_DETAIL_LINK');?></a>
                        <?endif;?>
                    </div>
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
    <?endforeach;?>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <?=$arResult["NAV_STRING"]?>
        </div>
    <?endif;?>
</div>