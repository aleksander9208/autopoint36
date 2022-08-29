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
<section class="s-posts">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2 class="section-title font-bold"><?=GetMessage('NEWS_TITLE')?></h2>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="owl-carousel post__slider">
                    <?foreach($arResult["ITEMS"] as $arItem):?>
                        <?
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="post" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <?if($arItem['PREVIEW_PICTURE']['SRC']):?>
                                <div class="post__thumb">
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>"></a>
                                </div>
                            <?endif;?>
                            <div class="post__content">
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="post__title font-bold"><?=$arItem['NAME']?></a>
                                <div class="post__date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></div>
                                <div class="post__excerpt"><?=$arItem['~PREVIEW_TEXT']?></div>
                                <div class="post__action">
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="adp-btn adp-btn--outline-primary"><?=GetMessage('SHOW_MORE')?></a>
                                </div>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    </div>
</section>