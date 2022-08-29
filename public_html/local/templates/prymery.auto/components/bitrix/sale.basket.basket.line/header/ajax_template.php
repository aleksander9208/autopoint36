<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$this->IncludeLangFile('template.php');

$cartId = $arParams['cartId'];

if ($arParams["SHOW_PRODUCTS"] == "Y") { ?>
    <a href="<?=$arParams['PATH_TO_BASKET']?>" class="adp-btn adp-btn--primary has-icon-leftward">
        <span class="icon"><i class="prymery-icon icon-shoping-cart-outline"></i></span>
        <?=GetMessage('BASKET_TITLE')?> (<?=$arResult['NUM_PRODUCTS']?>)
    </a>
    <script>
        BX.ready(function () {
            <?=$cartId?>.
            fixCart();
        });
    </script>
    <?
}