<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="container page_simple">
    <?
    ShowMessage($arParams["~AUTH_RESULT"]);
    ?>
	<form name="bform" method="post" class="form__user form__personal" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<? if (strlen($arResult["BACKURL"]) > 0):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<? endif;?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">

		<div class="form__registration form__forgot"><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></div>

        <div class="form__group">
            <label>
                <div class="form__name"><?= GetMessage("AUTH_LOGIN") ?></div>
                <input type="text" name="USER_LOGIN" class="apd-input" placeholder="" value="<?= $arResult["LAST_LOGIN"] ?>">
            </label>
        </div>
        <div class="form__group">
            <input type="submit" name="send_account_info" class="adp-btn adp-btn--primary" value="<?= GetMessage("AUTH_SEND") ?>">
        </div>
	</form>
</div>
<script>
document.bform.USER_LOGIN.focus();
</script>