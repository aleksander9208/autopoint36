
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($_REQUEST["ACTION"] == "DELAY" && $_REQUEST['ID'])
{
    if(!\Bitrix\Main\Loader::includeModule("sale") || !\Bitrix\Main\Loader::includeModule("catalog") || !\Bitrix\Main\Loader::includeModule("iblock") || !\Bitrix\Main\Loader::includeModule("prymery.auto"))
    {
        echo "failure";
        return;
    }

    $dbBasketItems = CSaleBasket::GetList(
        array("NAME" => "ASC", "ID" => "ASC"),
        array("PRODUCT_ID" => $_REQUEST["ID"], "FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "CAN_BUY" => "Y", "SUBSCRIBE" => "N"),
        false, false, array("ID", "PRODUCT_ID", "DELAY")
    )->Fetch();
    if(!empty($dbBasketItems) && $dbBasketItems["DELAY"] == "N")
    {
        $arFields = array("DELAY" => "Y", "SUBSCRIBE" => "N");
        if($_REQUEST["quantity"]){
            $arFields['QUANTITY'] = $_REQUEST["quantity"];
        }
        CSaleBasket::Update($dbBasketItems["ID"], $arFields);
    }
    elseif(!empty($dbBasketItems) && $dbBasketItems["DELAY"] == "Y")
    {
        CSaleBasket::Delete($dbBasketItems["ID"]);
        echo 'delete';
    }else
    {
        echo 'add';
        $id = Add2BasketByProductID($_REQUEST["ID"], 1);
        if(!$id)
        {
            if ($ex = $APPLICATION->GetException())
                $strErrorExt = $ex->GetString();
            $successfulAdd=false;
            $strError = "ERROR_ADD2BASKET";
        }

        $arFields = array("DELAY" => "Y", "SUBSCRIBE" => "N");
        CSaleBasket::Update($id, $arFields);
    }


    die();
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>