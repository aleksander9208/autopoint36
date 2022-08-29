<? if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


if ($_REQUEST["ACTION"]=='DELETEALL' and CModule::IncludeModule("sale"))
{
    CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
?>