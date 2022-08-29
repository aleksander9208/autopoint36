<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<div class="modalForm">
    <div class="modalForm__title">
        <?= GetMessage('FORM_HEADER_CAPTION') ?>
    </div>
    <form method="post" id="quick_order_form" data-success="<?=GetMessage('SUCCESS_TEXT')?>" action="<?= $arResult['AJAX_PATH'] ?>/ajax.php">
        <? foreach ($arParams['PROPERTIES'] as $field): ?>
            <div class="modalForm__group">
                <span class="modalForm__inputTitle"><?= GetMessage('CAPTION_' . $field) ?><? if (in_array($field, $arParams['REQUIRED'])): ?><span class="star">*</span><? endif; ?></span>
                <input type="<?= ($field == "EMAIL" ? "email" : ($field == "PHONE" ? "tel" : "text")); ?>"
                       name="QUICK_FORM[<?= $field ?>]" value="<?= $value ?>"
                       class="inputtext" id="quick_order_form_<?= $field ?>"/>
            </div>
        <? endforeach; ?>
        <div class="modalForm__group">
            <span class="modalForm__inputTitle">
                <?= GetMessage('CAPTION_COMMENT') ?>
            </span>
            <textarea name="QUICK_FORM[COMMENT]" cols="40" rows="5" id="quick_order_form_COMMENT"></textarea>
        </div>
        <div class="modalForm__btn">
            <button class="adp-btn adp-btn--primary" type="submit" id="quick_order_form_button" name="quick_order_form_button">
                <?= GetMessage("ORDER_BUTTON_CAPTION") ?>
            </button>
        </div>
        <? if (intVal($arParams['IBLOCK_ID'])): ?>
            <input type="hidden" name="IBLOCK_ID" value="<?= intVal($arParams['IBLOCK_ID']); ?>"/>
        <? endif; ?>
        <? if (intVal($arParams['ELEMENT_ID'])): ?>
            <input type="hidden" name="ELEMENT_ID" value="<?= intVal($arParams['ELEMENT_ID']); ?>"/>
        <? endif; ?>
        <input type="hidden" name="SITE_ID" value="<?= SITE_ID; ?>"/>
        <?= bitrix_sessid_post() ?>
    </form>
    <script src="<?=$templateFolder?>/script.js"></script>
</div>