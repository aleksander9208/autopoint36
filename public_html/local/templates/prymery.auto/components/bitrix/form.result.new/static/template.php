<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//pre($arResult);
?>
<div class="staticForm">
    <?/*if ($arResult["isFormErrors"] == "Y"):?>
        <div class="form__registration">
            <?=$arResult["FORM_ERRORS_TEXT"];?>
        </div>
    <?endif;*/?>
    <?if($arResult["FORM_NOTE"]):?>
        <?=GetMessage('SUCCESS_TEXT')?>
    <?endif;?>
    <?if ($arResult["isFormNote"] != "Y"):?>
        <?=$arResult["FORM_HEADER"]?>
        <div class="staticForm__group_text">
            <?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):
                if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'):
                    echo $arQuestion["HTML_CODE"];
                else:?>
                <?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'textarea'):?>
                    </div><div class="staticForm__group_textarea">
                <?endif;?>
                    <div class="staticForm__group<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?> novalid<?endif;?>">
                        <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
                            <span class="error-fld"></span>
                        <?endif;?>
                        <div class="form__name">
                            <?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
                        </div>
                        <?=$arQuestion["HTML_CODE"]?>
                    </div>
                <?endif;
            endforeach; ?>
            <?if($arResult["isUseCaptcha"] == "Y"):?>
                <div class="staticForm__group">
                    <b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b>
                    <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /><br />
                    <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?><br />
                    <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
                </div>
            <?endif;?>
            <div class="staticForm__btn">
                <button class="adp-btn adp-btn--primary" type="submit" name="web_form_submit">
                    <?=$arResult["arForm"]["BUTTON"];?>
                </button>
            </div>
        </div>
        <div class="clearfix"></div>
        <?=$arResult["FORM_FOOTER"]?>
    <?endif;?>
</div>
<script src="<?=$templateFolder?>/script.js"></script>