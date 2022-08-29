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
<div class="slider-container">
    <div class="owl-carousel hot-slider">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="product-hot product-hot--lg bg-cover-center" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="background-image: url(<?=$arItem['DETAIL_PICTURE']['SRC']?>);">
                <?if($arItem['PROPERTIES']['RED_LABEL']['VALUE']):?>
                <div class="product-hot__labels">
                    <div class="label label__action"><?=$arItem['PROPERTIES']['RED_LABEL']['VALUE']?></div>
                    </div>
                <?endif;?>
                <div class="product-hot__inner d-flex flex-column-reverse flex-lg-row">
                    <div class="product-hot__content">
                        <div class="product-hot__title font-bold">
                            <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" title="<?=$arItem['NAME']?>"><?=$arItem['~NAME']?></a>
                        </div>
                        <?if($arItem['PREVIEW_TEXT']):?>
                            <div class="product-hot__description">
                                <?=$arItem['~PREVIEW_TEXT']?>
                            </div>
                        <?endif;?>
                        <?if($arItem['PROPERTIES']['BUTTON']['VALUE']):?>
                            <div class="product-hot__action">
                                <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" title="<?=$arItem['PROPERTIES']['BUTTON']['VALUE']?>">
                                    <?=$arItem['PROPERTIES']['BUTTON']['VALUE']?>
                                </a>
                            </div>
                        <?endif;?>
                    </div>
                    <div class="product-hot__thumb">
                        <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>"></a>
                    </div>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>