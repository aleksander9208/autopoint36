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
        $obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId); $catalog_quantity = 0;
        ?>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="product__item product-display__table" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="product__thumb">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
						<?if($arItem['PREVIEW_PICTURE']['SRC']) {?>
							<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
						<?} else {?>
							<img src="/bitrix/templates/prymery.auto/assets/img/no_photo.png" alt="no_photo">
						<?}?>
					</a>
                </div>

                <div class="product__content d-flex flex-column">
                    <div class="product__title">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                    </div>
                    <div class="product-count text-secondary">
                        <?if($arItem['CATALOG_QUANTITY']>0):?>
                            <span class="icon quantity-exist"><i class="icon-check-circle"></i></span><?=GetMessage('CATALOG_IN_AVAIABLE')?>
                        <?else:?>
                            <span class="icon quantity-null"><i class="icon-times"></i></span>Ожидается<?//=GetMessage('CATALOG_NOT_AVAIABLE')?>
                        <?endif;?>
                    </div>
                </div>

                <div class="product__pricing d-flex flex-column">
                    <div class="product__price d-flex flex-row align-items-center">
                        <div class="product__price--new"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE_VAT']?></div>
                        <?if($arItem['MIN_PRICE']['VALUE_NOVAT']>$arItem['MIN_PRICE']['DISCOUNT_VALUE_NOVAT']):?>
                            <div class="product__price--old"><?=$arItem['MIN_PRICE']['PRINT_VALUE_VAT']?></div>
                        <?endif;?>
                    </div>

                    <div class="product__labels d-flex">
                        <?$count_label = 0;?>
                        <?if($arItem['PROPERTIES']['HIT']['VALUE']):?>
                            <div class="label label--hit"><?=GetMessage('CATALOG_HIT');?></div>
                            <?  $count_label++;
                        endif;?>
                        <?if($arItem['PROPERTIES']['SALE']['VALUE'] && $count_label<2):?>
                            <div class="label label--action"><?=GetMessage('CATALOG_SALE');?></div>
                            <?  $count_label++;
                        endif;?>
                        <?if($arItem['PROPERTIES']['NEW']['VALUE'] && $count_label<2):?>
                            <div class="label label--new"><?=GetMessage('CATALOG_NEW');?></div>
                        <?endif;?>
                    </div>
                </div>

                <div class="product__evaluation d-flex">
                    <div class="product__action" id="<?=$areaId.'_basket_actions'?>">
                        <?if($arItem['CATALOG_CAN_BUY_ZERO']=='Y' || $arItem['CATALOG_QUANTITY']>0):?>
                            <div class="adp-quantity quantity-light">
                                <button class="quantity-controller quantity-minus" type="button">-</button>
                                <input id="<?=$areaId.'_quantity'?>" type="text" value="1" class="quantity__value">
                                <button class="quantity-controller quantity-plus" type="button">+</button>
                            </div>
                            <a href="javascript:void(0);" id="<?=$areaId.'_buy_link'?>" class="adp-btn adp-btn--primary"><?=GetMessage('CATALOG_INBASKET');?></a>
                        <?else:?>
                            <div class="adp-quantity quantity-light">
                                <button class="quantity-controller quantity-minus" type="button">-</button>
                                <input id="<?=$areaId.'_quantity'?>" type="text" value="1" class="quantity__value">
                                <button class="quantity-controller quantity-plus" type="button">+</button>
                            </div>
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="adp-btn adp-btn--primary product__detail-btn">
                                <?=GetMessage('CATALOG_DETAIL_LINK');?>
                            </a>
                        <?endif;?>
                    </div>
                </div>
                <div class="product-postpone product-postpone__list product-postpone__table d-flex">
                    <a href="javascript:void(0)" class="add-favorites" data-id="<?=$arItem['ID']?>"><span class="icon"><i class="icon-heart-outline"></i></span></a>
                    <a href="javascript:void(0)" data-url="<?=$APPLICATION->GetCurPage()?>" class="add-compare" data-id="<?=$arItem['ID']?>"><span class="icon"><i class="icon-chart"></i></span></a>
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