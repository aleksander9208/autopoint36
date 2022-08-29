<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);
?>
<div class="slider-container">
    <div class="owl-carousel hot-slider--small">
        <?foreach($arResult['ITEMS'] as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            $uniqueId = $arItem['ID'].'_'.md5($this->randString().$component->getAction());
            $areaId = $areaIds[$arItem['ID']] = $this->GetEditAreaId($uniqueId);
            $obName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $areaId);
            ?>
            <div class="product-hot" id="<?=$this->GetEditAreaId($arItem['ID']);?>"<?if($arItem['PROPERTIES']['NEW_SLIDER_BG']['VALUE']):?> style="background-color: <?=$arItem['PROPERTIES']['NEW_SLIDER_BG']['VALUE']?>;" <?endif;?>>
                <?if($arItem['PROPERTIES']['BLUE_LABEL']['VALUE']):?>
                    <div class="product-hot__labels">
                        <div class="label label__hit"><?=$arItem['PROPERTIES']['BLUE_LABEL']['VALUE'];?></div>
                    </div>
                <?endif;?>
                <div class="product-hot__inner d-flex flex-column">
                    <div class="product-hot__thumb">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>"></a>
                    </div>
                    <div class="product-hot__content">
                        <div class="product-hot__title font-bold">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="product-hot__price font-bold"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE_VAT']?></div>
                            <div class="product-hot__action" id="<?=$areaId.'_basket_actions'?>">
                                <a href="javascript:void(0)" id="<?=$areaId.'_buy_link'?>" class="adp-btn adp-btn--accent has-icon-leftward">
                                    <span class="icon"><i class="prymery-icon icon-shoping-cart"></i></span>
                                    В корзину
                                </a>
                            </div>
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
    </div>
</div>