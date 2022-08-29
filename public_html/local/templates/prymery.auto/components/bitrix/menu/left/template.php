<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
?>

<? if (!empty($arResult)): ?>
    <section class="widget widget-navigation personal-navigation">
        <div class="toggle-navigation"><span><?=GetMessage('MENU_TITLE');?></span></div>
        <ul>
            <?
            foreach ($arResult as $arItem):
                if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                    continue;
                ?>
                <? if ($arItem["SELECTED"]):?>
                <li class="active"><a href="<?= $arItem["LINK"] ?>" title="<?= $arItem["TEXT"] ?>"><?= $arItem["TEXT"] ?></a></li>
            <? else:?>
                <li><a href="<?= $arItem["LINK"] ?>" title="<?= $arItem["TEXT"] ?>"><?= $arItem["TEXT"] ?></a></li>
            <? endif ?>
            <? endforeach ?>
        </ul>
        <?if ($USER->IsAuthorized() && $GLOBALS['PAGE'][1] == 'personal'):?>
            <a href="<?=$APPLICATION->GetCurPageParam("logout=yes", array());?>" class="link--primary link--logout">
                <img class="img-svg" src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/angle-left.svg" alt="Data Solution">
                <?=GetMessage('MENU_OUT');?>
            </a>
        <?endif;?>
    </section>
<? endif ?>