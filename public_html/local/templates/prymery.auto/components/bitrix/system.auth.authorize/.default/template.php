<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="container page_simple">
    <div class="form__registration">
        <?
        ShowMessage($arParams["~AUTH_RESULT"]);
        ShowMessage($arResult['ERROR_MESSAGE']);
        ?>
        <?=GetMessage('AUTH_FIRST_ONE');?> <a href="<?= $arResult["AUTH_REGISTER_URL"] ?>" rel="nofollow" title="<?=GetMessage('REGISTRATION_TITLE');?>" class="defLink"><?=GetMessage('AUTH_REGISTER');?></a>.
    </div>
    <form name="form_auth" method="post" class="form__user form__personal" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
        <input type="hidden" name="AUTH_FORM" value="Y"/>
        <input type="hidden" name="TYPE" value="AUTH"/>
        <? if (strlen($arResult["BACKURL"]) > 0): ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
        <? endif ?>
        <? foreach ($arResult["POST"] as $key => $value): ?>
            <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
        <? endforeach ?>
        <div class="form__group">
            <label>
                <div class="form__name"><?= GetMessage("AUTH_LOGIN") ?></div>
                <input type="text" name="USER_LOGIN" class="apd-input" placeholder=""
                       value="<?= $arResult["LAST_LOGIN"] ?>">
            </label>
        </div>
        <div class="form__group">
            <label>
                <div class="form__name">
                    <?= GetMessage("AUTH_PASSWORD") ?>
                    <div class="form__forgot-block">
                        <? if ($arParams["NOT_SHOW_LINKS"] != "Y"): ?>
                            <noindex>
                                <a href="<?= $arResult["AUTH_FORGOT_PASSWORD_URL"] ?>" rel="nofollow"
                                   class="defLink"><?= GetMessage("AUTH_FORGOT_PASSWORD_2") ?></a>
                            </noindex>
                        <? endif ?>
                    </div>
                </div>
                <input type="password" name="USER_PASSWORD" class="apd-input" placeholder="">
            </label>
        </div>
        <? if ($arResult["SECURE_AUTH"]): ?>
            <noscript>
				<span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
            </noscript>
            <script type="text/javascript">
                document.getElementById('bx_auth_secure').style.display = 'inline-block';
            </script>
        <? endif ?>
        <? if ($arResult["CAPTCHA_CODE"]): ?>
            <div class="form__group">
                <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180"
                     height="40" alt="CAPTCHA"/>

                <div class="form__name"><?= GetMessage("AUTH_CAPTCHA_PROMT") ?></div>
                <input class="bx-auth-input" type="text" name="captcha_word" maxlength="50" value="" size="15"/>
            </div>
        <? endif; ?>
        <? if ($arResult["STORE_PASSWORD"] == "Y"): ?>
            <div class="form__group">
                <input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER"
                                                            value="Y"/>
                <label for="USER_REMEMBER" class="form__name form__checkbox">&nbsp;<?= GetMessage("AUTH_REMEMBER_ME") ?></label>
            </div>
        <? endif ?>

        <div class="form__group">
            <input type="submit" name="Login" class="adp-btn adp-btn--primary" value="<?= GetMessage("AUTH_AUTHORIZE") ?>">
        </div>
    </form>
    <script type="text/javascript">
        <? if (strlen($arResult["LAST_LOGIN"]) > 0):?>
        try {
            document.form_auth.USER_PASSWORD.focus();
        } catch (e) {
        }
        <? else:?>
        try {
            document.form_auth.USER_LOGIN.focus();
        } catch (e) {
        }
        <? endif;?>
    </script>
    <? if ($arResult["AUTH_SERVICES"]): ?>
        <? $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
            array(
                "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                "CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
                "AUTH_URL" => $arResult["AUTH_URL"],
                "POST" => $arResult["POST"],
                "SHOW_TITLES" => $arResult["FOR_INTRANET"] ? 'N' : 'Y',
                "FOR_SPLIT" => $arResult["FOR_INTRANET"] ? 'Y' : 'N',
                "AUTH_LINE" => $arResult["FOR_INTRANET"] ? 'N' : 'Y',
            ),
            $component,
            array("HIDE_ICONS" => "Y")
        );
        ?>
    <? endif ?>
</div>
