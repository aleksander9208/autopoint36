<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?if($_REQUEST['FORM_ID'] || $_REQUEST['WEB_FORM_ID']):?>
    <?if($_REQUEST['WEB_FORM_ID']){$form_id=$_REQUEST['WEB_FORM_ID'];}else{$form_id=$_REQUEST['FORM_ID'];}?>
    <? $APPLICATION->IncludeComponent(
        "bitrix:form.result.new",
        'modal',
        array(
            "SEF_MODE" => "N",
            "WEB_FORM_ID" => $form_id,
            "LIST_URL" => "",
            "EDIT_URL" => "",
            "SUCCESS_URL" => "",
            "CHAIN_ITEM_TEXT" => "",
            "CHAIN_ITEM_LINK" => "",
            "IGNORE_CUSTOM_TEMPLATE" => "Y",
            "USE_EXTENDED_ERRORS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "SEF_FOLDER" => "/",
            "COMPONENT_TEMPLATE" => "modal",
            "VARIABLE_ALIASES" => array(
                "WEB_FORM_ID" => "WEB_FORM_ID",
                "RESULT_ID" => "RESULT_ID",
            )
        ),
        false
    );
    ?>
<?else:?>
    <div>Не укзаан ID формы</div>
<?endif;?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>