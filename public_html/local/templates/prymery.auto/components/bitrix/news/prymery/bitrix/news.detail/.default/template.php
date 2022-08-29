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
<div class="newsDetail__date"><?=$arResult['DISPLAY_ACTIVE_FROM']?></div>
<div class="newsDetail">
    <?if($arResult['DETAIL_PICTURE']):?>
        <div class="newsDetail__img image-left col-md-4 col-sm-4 col-xs-12">
            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResult['NAME']?>">
        </div>
    <?endif;?>

    <?if($arResult['PREVIEW_TEXT']):?>
        <div class="newsDetail__text">
            <?=$arResult['~PREVIEW_TEXT'];?>
        </div>
    <?endif;?>

    <?if($arResult['DETAIL_TEXT']):?>
        <div class="newsDetail__text">
            <?=$arResult['~DETAIL_TEXT'];?>
        </div>
    <?endif;?>

</div>