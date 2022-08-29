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
<section class="s-hero">
    <div class="hero-wrapper">
        <div class="owl-carousel hero__slider">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="slide bg-cover-center" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/assets/img/hero/bg-hero-1.jpg');">
                    <div class="container">
                        <div class="hero__item d-flex justify-content-center align-items-center">
                            <?if($arItem['PROPERTIES']['NEW_PRICE']['VALUE'] || $arItem['PROPERTIES']['OLD_PRICE']['VALUE'] || $arItem['PROPERTIES']['TEXT_TOP']['VALUE']):?>
                                <div class="hero__pricing">
                                    <?if($arItem['PROPERTIES']['TEXT_TOP']['VALUE']):?>
                                        <div class="hero__title--sm font-bold"><?=$arItem['PROPERTIES']['TEXT_TOP']['VALUE']?></div>
                                    <?endif;?>
                                    <div class="hero__price">
                                        <?if($arItem['PROPERTIES']['NEW_PRICE']['VALUE']):?>
                                            <div class="hero__price--new font-bold"><?=$arItem['PROPERTIES']['NEW_PRICE']['VALUE']?></div>
                                        <?endif;?>
                                        <?if($arItem['PROPERTIES']['OLD_PRICE']['VALUE']):?>
                                            <div class="hero__price--old text-secondary font-semibold"><?=$arItem['PROPERTIES']['OLD_PRICE']['VALUE']?></div>
                                        <?endif;?>
                                    </div>
                                </div>
                                <div class="hero__thumb">
                                    <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"></a>
                                </div>
                                <div class="hero__content">
                                    <div class="hero__title font-bold">
                                        <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"><?=$arItem['~NAME']?></a>
                                    </div>
                                    <?if($arItem['PREVIEW_TEXT']):?>
                                        <div class="hero__description font-semibold">
                                            <?=$arItem['~PREVIEW_TEXT']?>
                                        </div>
                                    <?endif;?>
                                    <?if($arItem['PROPERTIES']['BUTTON']['VALUE']):?>
                                        <div class="hero__action">
                                            <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" title="<?=$arItem['PROPERTIES']['BUTTON']['VALUE']?>" class="adp-btn adp-btn--primary"><?=$arItem['PROPERTIES']['BUTTON']['VALUE']?></a>
                                        </div>
                                    <?endif;?>
                                </div>
                            <?else:?>
                                <div class="hero__content">
                                    <div class="hero__title font-bold">
                                        <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"><?=$arItem['~NAME']?></a>
                                    </div>
                                    <?if($arItem['PREVIEW_TEXT']):?>
                                        <div class="hero__description font-semibold">
                                            <?=$arItem['~PREVIEW_TEXT']?>
                                        </div>
                                    <?endif;?>
                                    <?if($arItem['PROPERTIES']['BUTTON']['VALUE']):?>
                                        <div class="hero__action">
                                            <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" title="<?=$arItem['PROPERTIES']['BUTTON']['VALUE']?>" class="adp-btn adp-btn--primary"><?=$arItem['PROPERTIES']['BUTTON']['VALUE']?></a>
                                        </div>
                                    <?endif;?>
                                </div>
                                <div class="hero__thumb">
                                    <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"></a>
                                </div>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
</section>