<?php
//namespace JunoXC;
if ($_POST) {
    // print_R($_POST);
    // die;
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Bitrix\Catalog;

Loc::loadMessages(__FILE__);

/** @noinspection PhpInconsistentReturnPointsInspection */
class xTools
{

    function GetGoogleDistance($from = "Воронеж",$to = "Москва"){
        if (!$from or !$to) return array('ERROR'=>'Точка отправления или точка назначения не заданы.');
        $cacheid='googledistance'.$from.$to;
        if (!$data=xCache::GetCache($cacheid)) {
            $from = urlencode($from);
            $to = urlencode($to);
            $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=ru-RU&sensor=false");
            $data = json_decode($data);
            xCache::SetCache($cacheid, $data);
        }

        if (!$data->rows[0]->elements[0]->duration->text)
            return array('ERROR'=>'Не удалось расчитать маршрут'); else
        return array("Откуда"=>$data->destination_addresses[0],
            "Куда"=> $data->origin_addresses[0] ,
            "Время"=> $data->rows[0]->elements[0]->duration->text,
            "Путь"=> $data->rows[0]->elements[0]->distance->text,
            "distance"=> $data->rows[0]->elements[0]->distance->value/1000);
    }


    function Add2BasketByProductID($productId, $quantity = 1, $rewriteFields = array(), $productParams = false)
    {

        global $APPLICATION;

        /* for old use */
        if ($productParams === false)
        {
            $productParams = $rewriteFields;
            $rewriteFields = array();
        }

        $rewrite = (!empty($rewriteFields) && is_array($rewriteFields));
        if ($rewrite && isset($rewriteFields['SUBSCRIBE']) && $rewriteFields['SUBSCRIBE'] == 'Y')
            return SubscribeProduct($productId, $rewriteFields, $productParams);

        $quantity = (empty($quantity) ? 1 : (float)$quantity);
        if ($quantity <= 0)
            $quantity = 1;

        $product = array(
            'PRODUCT_ID' => $productId,
            'QUANTITY' => $quantity
        );
        if (!empty($productParams))
            $product['PROPS'] = $productParams;

        $result = false;

        $basketResult = Catalog\Product\Basket::addProduct($product, ($rewrite ? $rewriteFields : array()));
        unset($product);	
		
        if ($basketResult->isSuccess()) {
            $data = $basketResult->getData();
            $result = $data['ID'];
            unset($data);
        } else {
			$errorMsg = htmlspecialchars(implode('; ', $basketResult->getErrorMessages()));
			
			$jsonMsg = '{
				"message": {
					"title": "Ошибка",
					"text": "' . $errorMsg . '"
				}
			}';
			
			die($jsonMsg);
			
            $APPLICATION->ThrowException(implode('; ', $basketResult->getErrorMessages()));
        }
        unset($basketResult);

        return $result;
    }

    function getFinalPriceInCurrency($item_id, $cnt = 1, $getName = "N", $sale_currency = 'RUB')
    {
        CModule::IncludeModule("iblock");
        CModule::IncludeModule("catalog");
        CModule::IncludeModule("sale");
        global $USER;

        // Проверяем, имеет ли товар торговые предложения?
        if (CCatalogSku::IsExistOffers($item_id)) {

            // Пытаемся найти цену среди торговых предложений
            $res = CIBlockElement::GetByID($item_id);

            if ($ar_res = $res->GetNext()) {
                $productName = $ar_res["NAME"];
                if (isset($ar_res['IBLOCK_ID']) && $ar_res['IBLOCK_ID']) {

                    // Ищем все тогровые предложения
                    $offers = CIBlockPriceTools::GetOffersArray(array(
                        'IBLOCK_ID' => $ar_res['IBLOCK_ID'],
                        'HIDE_NOT_AVAILABLE' => 'Y',
                        'CHECK_PERMISSIONS' => 'Y'
                    ), array($item_id), null, null, null, null, null, null, array('CURRENCY_ID' => $sale_currency),
                        $USER->getId(), null);

                    foreach ($offers as $offer) {

                        $price = CCatalogProduct::GetOptimalPrice($offer['ID'], $cnt, $USER->GetUserGroupArray(), 'N');
                        if (isset($price['PRICE'])) {

                            $final_price = $price['PRICE']['PRICE'];
                            $currency_code = $price['PRICE']['CURRENCY'];

                            // Ищем скидки и высчитываем стоимость с учетом найденных
                            $arDiscounts = CCatalogDiscount::GetDiscountByProduct($item_id, $USER->GetUserGroupArray(),
                                "N");
                            if (is_array($arDiscounts) && sizeof($arDiscounts) > 0) {
                                $final_price = CCatalogProduct::CountPriceWithDiscount($final_price, $currency_code,
                                    $arDiscounts);
                            }

                            // Конец цикла, используем найденные значения
                            break;
                        }

                    }
                }
            }

        } else {

            // Простой товар, без торговых предложений (для количества равному $cnt)
            $price = CCatalogProduct::GetOptimalPrice($item_id, $cnt, $USER->GetUserGroupArray(), 'N');

            // Получили цену?
            if (!$price || !isset($price['PRICE'])) {
                return false;
            }

            // Меняем код валюты, если нашли
            if (isset($price['CURRENCY'])) {
                $currency_code = $price['CURRENCY'];
            }
            if (isset($price['PRICE']['CURRENCY'])) {
                $currency_code = $price['PRICE']['CURRENCY'];
            }

            // Получаем итоговую цену
            $final_price = $price['PRICE']['PRICE'];

            // Ищем скидки и пересчитываем цену товара с их учетом
            $arDiscounts = CCatalogDiscount::GetDiscountByProduct($item_id, $USER->GetUserGroupArray(), "N", 2);
            if (is_array($arDiscounts) && sizeof($arDiscounts) > 0) {
                $final_price = CCatalogProduct::CountPriceWithDiscount($final_price, $currency_code, $arDiscounts);
            }

            if ($getName == "Y") {
                $res = CIBlockElement::GetByID($item_id);
                $ar_res = $res->GetNext();
                $productName = $ar_res["NAME"];
            }

        }

        // Если необходимо, конвертируем в нужную валюту
        if ($currency_code != $sale_currency) {
            $final_price = CCurrencyRates::ConvertCurrency($final_price, $currency_code, $sale_currency);
        }

        $arRes = array(
            "PRICE" => CurrencyFormat($price['PRICE']['PRICE'], $sale_currency),
            "FINAL_PRICE" => CurrencyFormat($final_price, $sale_currency),
            "CURRENCY" => $sale_currency,
            "DISCOUNT" => $arDiscounts,
        );

        if ($productName != "") {
            $arRes['NAME'] = $productName;
        }

        return $arRes;

    }

    static function Instagram($user, $token, $count = 10)
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/cache/instagram/';
        if ((time() - @filemtime($dir . 'tmp.tmp')) > 2400) {
            $url = "https://api.instagram.com/v1/users/" . $user . "/media/recent?access_token=" . $token;
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $json = curl_exec($ch);
            curl_close($ch);
            @mkdir($dir);
            file_put_contents($dir . 'tmp.tmp', $json);
        } else {
            $json = file_get_contents($dir . 'tmp.tmp');
        }

        $result = json_decode($json);
        if (isset($result->data)) {
            return $result->data;
        } else {
            return false;
        }
    }


    public static function ReIndex($IBLOCK_ID)
    {
      exit(1);
      set_time_limit(3000);
        $arSelect = Array("ID", "NAME", 'ACTIVE');
        $arFilter = Array("IBLOCK_ID" => IntVal($IBLOCK_ID));
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        $el = new CIBlockElement;
        $k=0;
        while ($c = $res->GetNext()) {
          if ($_SESSION['prods'][$c['ID']]) continue;
          $_SESSION['prods'][$c['ID']]=1;
            $el->Update($c['ID'], array('ACTIVE' => $c['ACTIVE']));
            $k++;
           // if ($k>10)  {exit('a-'.sizeof( $_SESSION['prods'])); }
           // CIBlockElement::UpdateSearch($c['ID'], true);
        }
    }

    public static function GetIBlockElementByCode($CODE, $IBLOCK_ID = 0)
    {
        $filter = array(
            '=CODE' => $CODE,
            //'=S155.PROPERTY_1442' => 879
        );
        if ($IBLOCK_ID) {
            $filter['=IBLOCK_ID'] = $IBLOCK_ID;
        }
        $result = Bitrix\Iblock\ElementTable::getList(

            array(
                'select' => array(
                    '*',
                ),
                'filter' => $filter,
                /*'order' => array(
                    'RATING' => 'DESC',
                    'ID' => 'ASC'
                )*/
            )
        );


        return $result->fetch();
    }

    public static function GetIBlockSectionByCode($CODE, $IBLOCK_ID = 0)
    {
        $filter = array(
            '=CODE' => $CODE,
            //'=S155.PROPERTY_1442' => 879
        );
        if ($IBLOCK_ID) {
            $filter['=IBLOCK_ID'] = $IBLOCK_ID;
        }
        $result = Bitrix\Iblock\SectionTable::getList(

            array(
                'select' => array(
                    '*',
                ),
                'filter' => $filter,
                /*'order' => array(
                    'RATING' => 'DESC',
                    'ID' => 'ASC'
                )*/
            )
        );


        return $result->fetch();
    }
    public static function GetIBlockElement($ID)
    {
        //$res = CIBlockElement::GetByID($_GET["PID"]);
        //if($ar_res = $res->GetNext())
        return GetIBlockElement($ID);
    }


    public static function GetIBlockSection($ID)
    {
        $res = CIBlockSection::GetByID($ID);
        if($ar_res = $res->GetNext())
        return $ar_res;
    }

    public static function price_clear($p)
    {
        $p = str_replace(' ', '', str_replace('руб.', '', $p));
        $p = CCurrencyLang::CurrencyFormat($p, 'RUB', true);
        $p = str_replace('руб.', '', $p);
        return $p;
    }

    public static function GetList($arFilter, $arSelect = false, $Pagesize = false, $withProp = true, $resize = false, $arOrder = false)
    {
		// if(!$arOrder) $arOrder = Array('SORT' => 'ASC');
		
        if (!is_array($arFilter)) {
            $arFilter = array('IBLOCK_ID' => $arFilter);
        }
		
		if ($Pagesize && !is_array($Pagesize)) {
            $Pagesize = Array("nPageSize" => $Pagesize);
        }
		
        if (!$arFilter['ACTIVE']) {
            $arFilter['ACTIVE'] = 'Y';
        }
		
		// if ($_SERVER['REMOTE_ADDR'] == '217.25.227.230'){ 
			// echo "<pre style='display: none;' alt='arOrder'>";
			// print_r($arOrder);
			// echo "</pre>";
		// }
			
        $res = CIBlockElement::GetList($arOrder, $arFilter, false, $Pagesize, $arSelect);
		
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $el = $arFields;
			if ($withProp) {
                $arProps = $ob->GetProperties();
                foreach ($arProps as &$P) {
                    if ($P['PROPERTY_TYPE'] == 'F') {
                        $P['VALUE'] = CFile::GetFileArray($P['VALUE']);
                    }
                }
                $el['PROP'] = $arProps;
            }
			
			// if($el['NAME'] == 'Maxler Сумка ' or $el['NAME'] == 'Fortius Эспандер Кистевой ') {
				// if ($_SERVER['REMOTE_ADDR'] == '217.25.227.230'){ 				
					// echo "<pre style='display: none;' alt='el'>";
					// print_r($el);
					// echo "</pre>";
				// }
			// }
			
            if ($el['PREVIEW_PICTURE']) {
                $el['PREVIEW_PICTURE'] = CFile::GetFileArray($el['PREVIEW_PICTURE']);
            }
            if ($el['DETAIL_PICTURE']) {
                $el['PREVIEW_PICTURE'] = CFile::GetFileArray($el['DETAIL_PICTURE']);
            }

            $E[] = $el;
        }
		
		echo "<pre style='disp2lay: none;' alt='arOrder'>";
		print_r($E);
		echo "</pre>";
        return $E;
    }
	
	public static function GetListDiscounts($arFilter, $arSelect = false, $Pagesize = false, $withProp = true, $resize = false, $arOrder = false) {	
        if (!is_array($arFilter)) {
            $arFilter = array('IBLOCK_ID' => $arFilter);
        }
		
		if ($Pagesize && !is_array($Pagesize)) {
            $Pagesize = Array("nPageSize" => $Pagesize);
        }
		 
        if (!$arFilter['ACTIVE']) {
            $arFilter['ACTIVE'] = 'Y';
        }
		
		$rFilter['DISCOUNT'] = 'Y';
		
        $res = CIBlockElement::GetList($arOrder, $arFilter, false, $Pagesize, $arSelect);

        while ($ob = $res->GetNextElement()) {

            $arFields = $ob->GetFields();
			
            $el = $arFields;
		
			// $el['DISCOUNT'] = $price['DISCOUNT']['ACTIVE'];
			
			if ($withProp) {
                $arProps = $ob->GetProperties();
                foreach ($arProps as &$P) {
                    if ($P['PROPERTY_TYPE'] == 'F') {
                        $P['VALUE'] = CFile::GetFileArray($P['VALUE']);
                    }
                } 
                $el['PROP'] = $arProps;
            }
			
            if ($el['PREVIEW_PICTURE']) {
                $el['PREVIEW_PICTURE'] = CFile::GetFileArray($el['PREVIEW_PICTURE']);
            }
            if ($el['DETAIL_PICTURE']) {
                $el['PREVIEW_PICTURE'] = CFile::GetFileArray($el['DETAIL_PICTURE']);
            }
			
			$price = CCatalogProduct::GetOptimalPrice($el['ID'], 1, array(), 'N');
			
			// if ($_SERVER['REMOTE_ADDR'] == '217.25.227.230'){
				// echo "<pre style='display: none;' alt='ACTIVE'>";
				// print_r($price['DISCOUNT']['ACTIVE']);
				// echo "</pre>";
			// } // if
				
			if($price['DISCOUNT']['ACTIVE'] == 'Y') {
				$el['DISCOUNT'] = $price['DISCOUNT']['ACTIVE'];
				$el['PROP']['SALE']['VALUE'] = $price['DISCOUNT']['ACTIVE'];
			}
			
			$E[] = $el;
			
			// $priceOriginal = $el['PROP']['MIN_SORT_PRICE']['VALUE'];
			
			// if ($el['DISCOUNT'] == 'Y') {
			
			// }
			
			// if ($_SERVER['REMOTE_ADDR'] == '217.25.227.230'){
				// echo "<pre style='display: none;' alt='el'>";
				// print_r($el['DISCOUNT']);
				// echo "</pre>";
				
				// echo "<pre style='display: none;' alt='el'>";
				// print_r($el['PROP']['SALE']['VALUE']);
				// echo "</pre>";
				
				// echo "<pre style='display: none;' alt='el'>";
				// print_r($E);
				// echo "</pre>";
			// } // if
        }
		
		return $E;
    }
	
    public static function plural_form($n, $forms)
    {

        return $n % 10 == 1 && $n % 100 != 11 ? $forms[0] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $forms[1] : $forms[2]);
    }

    public static function ClearCont()
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
    }

    public static function isAjax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    public static function Show_Ajax_SRC($MSG)
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        echo(json_encode($MSG));
        require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
        exit();

    }

    public static function Show_Ajax($MSG)
    {
        if (xTools::isAjax()) {
            ;
            if ($MSG) {
                global $APPLICATION;
                $APPLICATION->RestartBuffer();
                  if (is_array($MSG) and $MSG[1]) {
                    $MSG = implode("<br>", $MSG);
                    echo(json_encode(array('header'=>'Сообщение','text' => strip_tags($MSG, '<br>'))));
                } else {
                    if (is_array($MSG)) {
                        echo(json_encode($MSG));
                    } else {
                        echo(json_encode(array('header'=>'Сообщение','text' => strip_tags($MSG))));
                    }
                }
                require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
                exit();
            }

        }
    }

    public
    static function SimpleEditArea(
        $file,
        $nohtml = false
    ) {
        global $APPLICATION;
        $APPLICATION->IncludeComponent("bitrix:main.include", $nohtml ? 'nohtml' : "",
            array("AREA_FILE_SHOW" => "file", "PATH" => $file), false);
    }

    public
    static function EditArea(
        $file,
        $nohtml = false,
        $AREA_FILE_SHOW = 'file',
        $AREA_FILE_SUFFIX = ''
    ) {
        global $APPLICATION;
        $APPLICATION->IncludeComponent("bitrix:main.include", $nohtml ? 'nohtml' : "",
            array("AREA_FILE_SHOW" => $AREA_FILE_SHOW, "AREA_FILE_SUFFIX" => $AREA_FILE_SUFFIX, "PATH" => $file),
            false);
    }


    public
    static function GetPageAreaPath(
        $AREA_FILE_SUFFIX,
        $TYPE = ''
    ) {
        global $APPLICATION;
        $sRealFilePath = $_SERVER["REAL_FILE_PATH"] ?: $_SERVER["SCRIPT_FILENAME"];
        $sRealFilePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $sRealFilePath);
        $slash_pos = strrpos($sRealFilePath, "/");
        $sFilePath = substr($sRealFilePath, 0, $slash_pos + 1);
        if ($TYPE == 'sect') {
            $sFileName = "sect_" . $AREA_FILE_SUFFIX . ".php";
        } else {
            $sFileName = substr($sRealFilePath, $slash_pos + 1);
            $sFileName = substr($sFileName, 0, strlen($sFileName) - 4) . "_" . $AREA_FILE_SUFFIX . ".php";
        }
        return str_replace('//', '/', $_SERVER["DOCUMENT_ROOT"] . SITE_DIR . $sFilePath . $sFileName);
    }


    /**
     * Returns true if current request is AJAX
     * @return bool
     */
    static public function isAjax2()
    {
        return \Bitrix\Main\Application::getInstance()->getContext()->getRequest()->isAjaxRequest();
    }

    /**
     * Returns true if current request is AJAX composite
     * @return bool
     */
    static public function isComposite()
    {
        return \Bitrix\Main\Page\Frame::isAjaxRequest();
    }

    /**
     * Копия функции битрикса для определения логической кодировки сайта
     * Копия потому что функция битрикса требует $this а нам нужна статика
     * @return string
     */
    static public function getLogicalEncoding()
    {
        if (defined('BX_UTF')) {
            $logicalEncoding = "utf-8";
        } elseif (defined("SITE_CHARSET") && (strlen(SITE_CHARSET) > 0)) {
            $logicalEncoding = SITE_CHARSET;
        } elseif (defined("LANG_CHARSET") && (strlen(LANG_CHARSET) > 0)) {
            $logicalEncoding = LANG_CHARSET;
        } elseif (defined("BX_DEFAULT_CHARSET")) {
            $logicalEncoding = BX_DEFAULT_CHARSET;
        } else {
            $logicalEncoding = "windows-1251";
        }

        return strtolower($logicalEncoding);
    }

    /**
     * Обертка для изменения кодировки через битрикс-функцию т.к. нам нужен объект класса
     * @param mixed $val
     * @param array $arEnc
     * @param bool $return
     * @return NULL|string
     * @internal param string $key
     */
    private static function ConvertCharset(&$val, $arEnc, $return = false)
    {
        global $APPLICATION;
        $val = $APPLICATION->ConvertCharset($val, $arEnc['from'], $arEnc['to']);
        if ($return) {
            return $val;
        }
        return true;
    }

    /**
     * Обертка проверяет нужно ли перекодирование, если да то делает его
     * @param $arRequest
     * @return bool
     */
    public static function encodeAjaxRequest(&$arRequest)
    {
        // ajax всегда прилетает в UTF-8, если кодировка сайта отличается, надо перекодировать
        if (($curEnc = self::getLogicalEncoding()) == 'utf-8') {
            return true;
        }
        //self::encodeArray($arRequest, 'utf-8', $curEnc);
        return true;
    }


    /**
     * Returns russian name of given filesize in bytes
     * @param integer $bytes - filesize in bytes
     * @param integer $decimals - preferred number of digits after point
     * @return string
     */
    static public function rusFilesize($bytes, $decimals = 2)
    {
        $arSize = array(
            GetMessage('RZ_BYTE'),
            GetMessage('RZ_KILOBYTE'),
            GetMessage('RZ_MEGABYTE'),
            GetMessage('RZ_GIGABYTE'),
            GetMessage('RZ_TERABYTE'),
        );
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $arSize[$factor];
    }

}



// Проверяем возможно ли добавить товар в корзину
function canAddToBasket($cityId, $storeId, $productId, $quantity = 1){
	$arStoks = array();
	// $arFilter = Array("PRODUCT_ID" => $productId);
	$arFilter = Array("PRODUCT_ID" => $productId, "STORE_DESCR" => $cityId);
	$res = CCatalogStoreProduct::GetList(Array(),$arFilter,false,false,Array());
	$isStoreCity = $isEnough = false;
	
	while ($arRes = $res->GetNext()){
		// $arStoks[] = $arRes;
			
		$arStoks[] = array(
			"ID" => $arRes["ID"],
			"CITY_ID" => $arRes["STORE_DESCR"],
			"PRODUCT_ID" => $arRes["PRODUCT_ID"],
			"STORE_ID" => $arRes["STORE_ID"],
			"AMOUNT" => $arRes["AMOUNT"],
			"STORE_NAME" => $arRes["STORE_NAME"],
		);	
		
		// if($arRes["STORE_DESCR"] == $cityId && $arRes["STORE_ID"] == $storeId){
		if($arRes["STORE_DESCR"] == $cityId){
			$isStoreCity = true;
			 
			if($arRes["AMOUNT"] >= $quantity) 
				$isEnough = true;
			
			// Проверяем изменился ли город
			if(!isset($_SESSION["stok_city"]) || $_SESSION["stok_city"] != $cityId){
				$_SESSION["stok_city"] = $cityId;
				$_SESSION["stoks"] = array();
			} // if
			
			// Сохраняем склады в массив
			if(!in_array($arRes["STORE_ID"], $_SESSION["stoks"]))
				$_SESSION["stoks"][] = $arRes["STORE_ID"];
			
			// break;
		} // if
	} // while
	
	$arResponse = array(
		"isStoreCity" => $isStoreCity,
		"isEnough" => $isEnough,
		"arStoks" => $arStoks,
		"arStocksList" => $arStocksList
		
	);

	return $arResponse;
} // canAddToBasket


// Проверяем возможно ли добавить товар в корзину не берем во внимания склад
function canAddToWarehouse($cityId, $productId, $quantity = 1){
	$arStoks = array();
	$arFilter = Array("PRODUCT_ID" => $productId);
	$res = CCatalogStoreProduct::GetList(Array(),$arFilter,false,false,Array());
	$isStoreCity = $isEnough = false;
	
	while ($arRes = $res->GetNext()){
		// $arStoks[] = $arRes;
				
		$arStoks[] = array(
			"ID" => $arRes["ID"],
			"CITY_ID" => $arRes["STORE_DESCR"],
			"PRODUCT_ID" => $arRes["PRODUCT_ID"],
			"STORE_ID" => $arRes["STORE_ID"],
			"AMOUNT" => $arRes["AMOUNT"],
			"STORE_NAME" => $arRes["STORE_NAME"],
		);
		
		if($arRes["STORE_DESCR"] == $cityId && $arRes["STORE_ID"] == $storeId){
			$isStoreCity = true;
			 
			if($arRes["AMOUNT"] >= $quantity)
				$isEnough = true;
			
			// Проверяем изменился ли город
			if(!isset($_SESSION["stok_city"]) || $_SESSION["stok_city"] != $cityId){
				$_SESSION["stok_city"] = $cityId;
				$_SESSION["stoks"] = array();
			} // if
			
			// Сохраняем склады в массив
			if(!in_array($arRes["STORE_ID"], $_SESSION["stoks"]))
				$_SESSION["stoks"][] = $arRes["STORE_ID"];
			
			// break;
		} // if
	} // while
	
	$arResponse = array(
		"isStoreCity" => $isStoreCity,
		"isEnough" => $isEnough,
		"arStoks" => $arStoks,
		"arStocksList" => $arStocksList
		
	);
	
	return $arResponse;
} // canAddToWarehouse


function canAddToStock($cityId, $storeId, $productId, $quantity = 1){
	$arStoks = array();
	$arFilter = Array("PRODUCT_ID" => $productId);
	$res = CCatalogStoreProduct::GetList(Array(),$arFilter,false,false,Array());
	$isStoreCity = $isEnough = false;
	
	while ($arRes = $res->GetNext()){
		$arStoks[] = $arRes;
		
		$arStoks[] = array(
			"ID" => $arRes["ID"],
			"CITY_ID" => $arRes["STORE_DESCR"],
			"PRODUCT_ID" => $arRes["PRODUCT_ID"],
			"STORE_ID" => $arRes["STORE_ID"],
			"AMOUNT" => $arRes["AMOUNT"],
			"STORE_NAME" => $arRes["STORE_NAME"],
		);
		
		if($arRes["STORE_DESCR"]){ 
			$isStoreCity = true;
			 
			if($arRes["AMOUNT"] >= $quantity)
				$isEnough = true;
			
			// Проверяем изменился ли город
			if(!isset($_SESSION["stok_city"]) || $_SESSION["stok_city"] != $cityId){
				$_SESSION["stok_city"] = $cityId;
				$_SESSION["stoks"] = array();
			} // if
			
			// Сохраняем склады в массив
			if(!in_array($arRes["STORE_ID"], $_SESSION["stoks"]))
				$_SESSION["stoks"][] = $arRes["STORE_ID"];
			
			// break;
		} // if
	} // while
	
	$arResponse = array(
		"isStoreCity" => $isStoreCity,
		"isEnough" => $isEnough,
		"arStoks" => $arStoks,
		"arStocksList" => $arStocksList
		
	);

	return $arResponse;
} // canAddToStock


//Получаем все склады на сайте по городу
function getStocks($cityId){
	$arFilter = Array("ACTIVE" => "Y", "DESCRIPTION" => $cityId);
	$res = CCatalogStore::GetList(Array(),$arFilter,false,false,Array());
	
	$arStoks = array();

	while ($arRes = $res->GetNext()){
		// $arStoks[] = $arRes;
		
		$arStoks[] = array(
			"ID" => $arRes["ID"],
			"TITLE" => $arRes["TITLE"],
			"DESCRIPTION" => $arRes["DESCRIPTION"],
		);
	} // while

	return $arStoks;
} // getStocks


//Получаем склады в корзине
function getByOffers($productId, $cityId, $quantity = 1){
	$arStoks = array();
	$arFilter = Array("PRODUCT_ID" => $productId, "STORE_DESCR" => $cityId, "ACTIVE" => 'Y');
	$res = CCatalogStoreProduct::GetList(Array(),$arFilter,false,false,Array('ID', 'STORE_DESCR', 'PRODUCT_ID', 'AMOUNT','STORE_ID','STORE_NAME'));

	while ($arRes = $res->GetNext()){
		$arStoks[] = array(
			"ID" => $arRes["ID"],
			"CITY_ID" => $arRes["STORE_DESCR"],
			"PRODUCT_ID" => $arRes["PRODUCT_ID"],
			"STORE_ID" => $arRes["STORE_ID"],
			"AMOUNT" => $arRes["AMOUNT"],
			"STORE_NAME" => $arRes["STORE_NAME"],
		);	
	} // while

	return $arStoks;
	
} // getTastesByCity


// Предикат для сортировки по наличию на складе
function orderByStocks($arItem1, $arItem2){
	return isExistsInStocks($arItem1) - isExistsInStocks($arItem2);
} // orderByStocks


// Предикат для сортировки по наличию на складе
function orderByStocksjax($arItem1, $arItem2){
	return isExistsInStocksAjax($arItem1) - isExistsInStocksAjax($arItem2);
} // orderByStocksjax


// Проверяем наличие товара на складе выбранного города
function isExistsInStocks($arItem){
	// Фильтрация вкусов по складам
	$cityId = $_SESSION["city"];
	$storeId = $_SESSION["store"];
	$arOffers = array();
 
	foreach($arItem["OFFERS"] as $arOffer){ 
		$arResponse = canAddToBasket($cityId, $storeId, $arOffer['ID']);
		// $arResponse = canAddToWarehouse($cityId, $arOffer['ID']);

		if($arResponse["isStoreCity"]) $arOffers[] = $arOffer;
	} // foreach

	return count($arOffers);
} // isExistsInStocks


// Проверяем наличие товара на складе выбранного города Ajax
function isExistsInStocksAjax($itemId){
	$arInfo = CCatalogSKU::GetInfoByProductIBlock(19);
	
	if (is_array($arInfo)) {
		$res = CIBlockElement::GetList(
			Array("PRICE" => "asc", "CATALOG_AVAILABLE" => "Y"), 
			array(
				'IBLOCK_ID' => $arInfo['IBLOCK_ID'], 
				'ACTIVE' => 'Y', 
				// "CATALOG_AVAILABLE" => "Y", 
				'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $itemId 
			), 
			false, 
			false, 
			array("ID", "NAME")
		);
	   
		// Фильтрация вкусов по складам
		$cityId = $_SESSION["city"];
		$storeId = $_SESSION["store"];
		$arOffers = array();
		$countOffers = 0;
	   
		while($ob = $res->GetNext()){
			$arResponse = canAddToBasket($cityId, $storeId, $ob['ID']);
			$countOffers++;
			
			// if($arResponse["isStoreCity"]) $arOffers[] = $ob;
			if($arResponse["arStoks"]) $arOffers[] = $ob;
		} // while
	} // if
	
	return count($arOffers) > 0;
} // isExistsInStocksAjax

// Получить список элементов инфоблока для поиска
function getElemensList($arFilter, $isProperties = true, $arOrder = Array("NAME" => "ASC"), $arSelect = false){
	if(!$arSelect)
		$arSelect = array("ID", "NAME", "IBLOCK_ID", "PREVIEW_TEXT", "DETAIL_TEXT", "DETAIL_PAGE_URL", "PROPERTIES_*");
	
	$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
	
	$arElements = array();
	
	while ($ob = $res->GetNextElement()){
		if($isProperties)
			$arElements[] = array_merge($ob->GetFields(), $ob->GetProperties());
		else
			$arElements[] = $ob->GetFields();
	} // while
		
	
	return $arElements;
} // getElemensList





