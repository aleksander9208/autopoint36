<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="container page_simple">
	<div class="bx-auth">
        <div class="form__registration">
            <?ShowMessage($arParams["~AUTH_RESULT"]);?>
            <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
                <p><?=GetMessage("AUTH_EMAIL_SENT")?></p>
            <?else:?>
            <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
                <p><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></p>
            <?endif?>
        </div>
        <noindex>
        <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" class="form__reg">
            <?if (strlen($arResult["BACKURL"]) > 0):?>
                <input type="hidden" name="backurl"  value="<?=$arResult["BACKURL"]?>" />
            <?endif?>
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="REGISTRATION" />

            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("AUTH_LOGIN_MIN") ?></div>
                    <input type="text" name="USER_LOGIN" class="apd-input" autocomplete="off" placeholder=""
                           value="<?= $arResult["USER_LOGIN"] ?>">
                </label>
                <span class="form__group_desc">
                    <?= GetMessage("LOGIN_DESC") ?>
                </span>
            </div>
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("AUTH_NAME") ?></div>
                    <input type="text" name="USER_NAME" class="apd-input" autocomplete="off" placeholder=""
                           value="<?= $arResult["USER_NAME"] ?>">
                </label>
                <span class="form__group_desc">
                    <?= GetMessage("NAME_DESC") ?>
                </span>
            </div>
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("AUTH_EMAIL") ?></div>
                    <input type="text" name="USER_EMAIL" class="apd-input" autocomplete="off" placeholder=""
                           value="<?= $arResult["USER_EMAIL"] ?>">
                </label>
                <span class="form__group_desc">
                    <?= GetMessage("EMAIL_DESC") ?>
                </span>
            </div>
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("AUTH_PASSWORD_REQ") ?></div>
                    <input type="text" name="USER_PASSWORD" class="apd-input" placeholder=""
                           value="<?= $arResult["USER_PASSWORD"] ?>">
                </label>
                <span class="form__group_desc">
                    <?= GetMessage("PASS_DESC") ?>
                </span>
            </div>
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("AUTH_CONFIRM") ?></div>
                    <input type="text" name="USER_CONFIRM_PASSWORD" class="apd-input" placeholder=""
                           value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>">
                </label>
            </div>

            <?if ($arResult["USE_CAPTCHA"] == "Y"):?>
                <div class="form__group">
                    <label>
                        <strong><b><?=GetMessage("CAPTCHA_REGF_TITLE")?></b></strong><br />
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br />
                        <strong><span class="starrequired">*</span><?=GetMessage("CAPTCHA_REGF_PROMT")?>:</strong><br />
                        <input type="text" name="captcha_word" maxlength="50" value="" class="input_text_style" />
                    </label>
                </div>
            <?endif?>

            <div class="form__group">
                <input type="checkbox" id="USER_PERSONAL" name="personal" value="Y"/>
                <label for="USER_PERSONAL" class="form__name form__checkbox form__checkbox_reg">
                    <?= GetMessage("USER_PERSONAL") ?>
                    <a href="<?=SITE_DIR?>privacy-policy/" class="defLink" rel="nofollow" title="<?=GetMessage('PERSONAL_DATA')?>" target="_blank"><?=GetMessage('PERSONAL_DATA')?></a>
                </label>
            </div>

            <div class="form__group">
                <input type="submit" name="Register" class="adp-btn adp-btn--primary" value="<?= GetMessage("AUTH_REGISTER") ?>">
            </div>
        </form>
        </noindex>
    <?endif;?>
	</div>
</div>
<script type="text/javascript">
	document.bform.USER_NAME.focus();
</script>