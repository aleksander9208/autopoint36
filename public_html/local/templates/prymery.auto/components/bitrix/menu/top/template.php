<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <button class="close-menu"><span class="icon"><i class="prymery-icon icon-times"></i></span></button>
    <ul class="main-navigation">
        <?
        foreach ($arResult as $arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <? if ($arItem["SELECTED"]):?>
            <li><a href="<?= $arItem["LINK"] ?>" class="selected" title="<?= $arItem["TEXT"] ?>"><?= $arItem["TEXT"] ?></a></li>
        <? else:?>
            <li><a href="<?= $arItem["LINK"] ?>" title="<?= $arItem["TEXT"] ?>"><?= $arItem["TEXT"] ?></a></li>
        <? endif ?>
        <? endforeach ?>
    </ul>
<? endif ?>