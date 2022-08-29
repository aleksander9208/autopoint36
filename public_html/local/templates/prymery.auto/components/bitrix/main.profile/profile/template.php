<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="container">
    <div class="form__registration">
        <?ShowError($arResult["strProfileError"]);?>
        <?if( $arResult['DATA_SAVED'] == 'Y' ) {?><?ShowNote(GetMessage('PROFILE_DATA_SAVED'))?><br /><?; }?>
    </div>
    <div class="form-block-wr">
        <form method="post" name="form1" class="main form__reg" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
            <?=$arResult["BX_SESSION_CHECK"]?>
            <input type="hidden" name="lang" value="<?=LANG?>" />
            <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("PERSONAL_LOGIN") ?></div>
                    <input type="text" name="LOGIN" class="personal__input apd-input" autocomplete="off" placeholder=""
                           value="<?=$arResult["arUser"]["LOGIN"]?>">
                </label>
                <span class="form__group_desc">
                    <?= GetMessage("LOGIN_DESC") ?>
                </span>
            </div>
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("PERSONAL_FIO") ?></div>
                    <input type="text" name="NAME" class="personal__input apd-input" autocomplete="off" placeholder=""
                           value="<?=$arResult["arUser"]["NAME"]?>">
                </label>
                <span class="form__group_desc">
                    <?= GetMessage("NAME_DESC") ?>
                </span>
            </div>
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("PERSONAL_PHONE") ?></div>
                    <input type="text" name="PERSONAL_PHONE" class="personal__input apd-input" autocomplete="off" placeholder=""
                           value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>">
                </label>
                <span class="form__group_desc">
                    <?= GetMessage("PHONE_DESC") ?>
                </span>
            </div>
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("PERSONAL_EMAIL") ?></div>
                    <input type="text" name="EMAIL" class="personal__input apd-input" autocomplete="off" placeholder=""
                           value="<?=$arResult["arUser"]["EMAIL"]?>">
                </label>
                <span class="form__group_desc">
                    <?= GetMessage("EMAIL_DESC") ?>
                </span>
            </div>
            <div class="form__group">
                <input type="submit" name="save" class="adp-btn adp-btn--primary" value="<?= GetMessage("PROFILE_SAVE") ?>">
            </div>
        </form>
        <? if($arResult["SOCSERV_ENABLED"]){ $APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "", array("SUFFIX"=>"form", "SHOW_PROFILES" => "Y","ALLOW_DELETE" => "Y"),false);}?>
    </div>
</div>