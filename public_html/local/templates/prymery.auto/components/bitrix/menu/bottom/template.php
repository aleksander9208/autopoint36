<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <ul>
        <?
        foreach ($arResult as $key=>$arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <? if ($arItem["SELECTED"]):?>
                <li><a href="<?= $arItem["LINK"] ?>" class="selected" title="<?= $arItem["TEXT"] ?>"><?= $arItem["TEXT"] ?></a></li>
            <? else:?>
                <li><a href="<?= $arItem["LINK"] ?>" title="<?= $arItem["TEXT"] ?>"><?= $arItem["TEXT"] ?></a></li>
            <? endif ?>
            <?if($key==4 && count($arResult)>5):?></ul><ul><?endif;?>
        <? endforeach ?>
    </ul>
<? endif ?>