<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="container page_simple">
    <div class="content-form changepswd-form">
    <? ShowMessage($arParams["~AUTH_RESULT"]); ?>

    <form method="post" class="form__user form__personal" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
        <?if (strlen($arResult["BACKURL"]) > 0): ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="CHANGE_PWD">
        <div class="form__group">
            <label>
                <div class="form__name"><?= GetMessage("AUTH_LOGIN") ?></div>
                <input type="text" name="USER_LOGIN" class="apd-input" placeholder=""
                       value="<?= $arResult["LAST_LOGIN"] ?>">
            </label>
        </div>
        <div class="form__group">
            <label>
                <div class="form__name"><?= GetMessage("AUTH_CHECKWORD") ?></div>
                <input type="text" name="USER_CHECKWORD" class="apd-input" placeholder=""
                       value="<?= $arResult["USER_CHECKWORD"] ?>">
            </label>
        </div>
        <div class="form__group">
            <label>
                <div class="form__name"><?= GetMessage("AUTH_NEW_PASSWORD_REQ") ?></div>
                <input class="apd-input" type="password" size="25" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" />
            </label>
        </div>
        <div class="form__group">
            <label>
                <div class="form__name"><?= GetMessage("AUTH_NEW_PASSWORD_CONFIRM") ?></div>
                <input class="apd-input" type="password" size="25" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>"  />
            </label>
        </div>

        <div class="form__group">
            <input type="submit" size="25" class="adp-btn adp-btn--primary" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" /></div>
        </div>

        <a href="<?=$arResult["AUTH_AUTH_URL"]?>" title="<?=GetMessage("AUTH_AUTH")?>" class="defLink auth-link"><?=GetMessage("AUTH_AUTH")?></a>
    </form>

    <script type="text/javascript">
    document.bform.USER_LOGIN.focus();
    </script>
    </div>
</div>