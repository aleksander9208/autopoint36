<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);
?>
<div class="container">
    <div class="row">
        <div class="owl-carousel recomendation__slider">
            <?foreach($arResult['ITEMS'] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="product__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
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
                    <div class="product__thumb 1">
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>"></a>
                    </div>
                    <div class="product__content">
                        <div class="product__title">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
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
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
</div>