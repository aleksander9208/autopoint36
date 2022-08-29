<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

?><?

if ($_GET['remake_brands']) {
	
	CModule::IncludeModule('iblock');
	CModule::IncludeModule('highloadblock');

	$IBLOCK = 8; //catalog
	$dbGoods = CIBlockElement::GetList([],
		["IBLOCK_ID" => $IBLOCK],
		['PROPERTY_PROIZVODITEL','ACTIVE'=>'Y'], 
		FALSE,
		FALSE,
		["ID", "PROPERTY_PROIZVODITEL","ACTIVE"]);
	$goods = [];
	$cel = new CIBlockElement;
	while ($good = $dbGoods->GetNext()) {
		// if ($good['PROPERTY_CML2_MANUFACTURER_VALUE'] !== "") {
			// if (!in_array($good['PROPERTY_CML2_MANUFACTURER_VALUE'],
				// $goods) && $good['PROPERTY_CML2_MANUFACTURER_VALUE'] !== NULL) {
				// $goods[] = ($good['PROPERTY_CML2_MANUFACTURER_VALUE']);
			// }
		// }
		
		if ($good['PROPERTY_PROIZVODITEL_VALUE'] !== "") {
			if (!in_array($good['PROPERTY_PROIZVODITEL_VALUE'],
				$goods) && $good['PROPERTY_PROIZVODITEL_VALUE'] !== NULL) {
				
				$hlblock = HL\HighloadBlockTable::getById(4)->fetch(); // id highload блока
				$entity = HL\HighloadBlockTable::compileEntity($hlblock);
				$entityClass = $entity->getDataClass();

				$res = $entityClass::getList(array(
				   'select' => array('*'),
				   'filter' => array('UF_XML_ID' => $good['PROPERTY_PROIZVODITEL_VALUE'])
				));

				$row = $res->fetch();

                // echo "<pre style='display: none;' alt='row'>";
                // print_r($row);
                // echo "</pre>";

				$goods[] = ($row['UF_NAME']);
			}
		}
	}
	
	
	$arFilter = ["IBLOCK_ID" => 2];//,'ACTIVE'=>"Y"
	$res = CIBlockElement::GetList(['NAME' => 'ASC'], $arFilter,
		['NAME', 'ID', 'ACTIVE','PREVIEW_TEXT'], FALSE, ['*']);
	while ($el = $res->getNext()) {
		$BRANDS[] = $el['NAME'];
		if ($el['ACTIVE'] == 'Y') {
			$BRANDS2[] = $el['NAME'];
		}
		$BRANDSIDS[$el['NAME']] = $el['ID'];
	}


    $arParams = ["replace_space" => "_", "replace_other" => "_"];

	$arDiffBrands = array_diff($goods, $BRANDS);
	$arDiffBrands_onsite = array_diff($BRANDS2, $goods);
	$arInterBrands = array_intersect($goods, $BRANDS);

	// echo "<pre style='disp2lay: none;' alt='arDiffBrands_onsite'>";
	// print_r($arDiffBrands_onsite); 
	// echo "</pre>";
	
	// echo "<pre style='disp2lay: none;' alt='BRANDS'>";
	// print_r($BRANDS);
	// echo "</pre>";
	
	// echo "<pre style='disp2lay: none;' alt='arInterBrands'>";
	// print_r($arInterBrands);
	// echo "</pre>";
	
	// die;



	if ($arDiffBrands) {
		foreach ($arDiffBrands as $brand) {
			$arLoadProductArray = [
				"IBLOCK_ID" => 2,
				"NAME" => $brand,
				"CODE" => Cutil::translit($brand, "ru", $arParams),
				"ACTIVE" => "Y",
			];
			$cel->Add($arLoadProductArray);
		}
	}

	if ($arInterBrands) {
		foreach ($arInterBrands as $brand) {
			$arLoadProductArray = ["ACTIVE" => "Y",];
			$cel->Update($BRANDSIDS[$brand], $arLoadProductArray);
		}
	}
	
	if ($arDiffBrands_onsite) {
		foreach ($arDiffBrands_onsite as $brand) {
			$arLoadProductArray = ["ACTIVE" => "Y",];
			$cel->Update($BRANDSIDS[$brand],$arLoadProductArray);
		}
	}
}
define('ITS_BRAND', 1);
?>

<div class="main-content container">
 <?
 
 $APPLICATION->IncludeComponent(
	"bitrix:news",
	"brands",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array("",""),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array("",""),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILE_404" => "",
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "prymery_content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array("",""),
		"LIST_PROPERTY_CODE" => array("",""),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "2000",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"SEF_FOLDER" => "/brand/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("detail"=>"#ELEMENT_CODE#/","news"=>"","section"=>"#SECTION_CODE#/"),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N"
	)
);

?>

</div>






<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>