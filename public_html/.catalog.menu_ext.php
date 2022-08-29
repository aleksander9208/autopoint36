<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $APPLICATION, $arTheme;
$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
    "IS_SEF" => "Y",
    "SEF_BASE_URL" => "",
    // "IBLOCK_TYPE" => 'prymery_catalog',
    "IBLOCK_TYPE" => '1c_catalog',
    //"IBLOCK_ID" => PRauto::CIBlock_Id('prymery_catalog','prymery_catalog'),
    "IBLOCK_ID" => 8,
    "DEPTH_LEVEL" => "1",
    "CACHE_TYPE" => "N",
), false, Array('HIDE_ICONS' => 'Y'));
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>