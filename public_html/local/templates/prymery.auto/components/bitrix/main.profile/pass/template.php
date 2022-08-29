<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<div class="container">
    <div class="form__registration">
        <?ShowError($arResult["strProfileError"]);?>
        <?if ($arResult['DATA_SAVED'] == 'Y') ShowNote(GetMessage('PROFILE_DATA_SAVED'));?>
    </div>
	<div class="form-block-wr">
		<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
			<?=$arResult["BX_SESSION_CHECK"]?>
			<input type="hidden" name="LOGIN" maxlength="50" value="<?=$arResult["arUser"]["LOGIN"]?>" />
			<input type="hidden" name="EMAIL" maxlength="50" placeholder="name@company.ru" value="<?=$arResult["arUser"]["EMAIL"]?>" />
			<input type="hidden" name="lang" value="<?=LANG?>" />
			<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("NEW_PASSWORD_REQ") ?></div>
                    <input type="password" name="NEW_PASSWORD" class="personal__input apd-input" autocomplete="off" placeholder="">
                </label>
            </div>
            <div class="form__group">
                <label>
                    <div class="form__name"><?= GetMessage("NEW_PASSWORD_CONFIRM") ?></div>
                    <input type="password" name="NEW_PASSWORD_CONFIRM" class="personal__input apd-input" autocomplete="off" placeholder="">
                </label>
            </div>
            <div class="form__group">
                <input type="submit" name="save" class="adp-btn adp-btn--primary" value="<?= GetMessage("SAVE") ?>">
            </div>
		</form>
	</div>
</div>