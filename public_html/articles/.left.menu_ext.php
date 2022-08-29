<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $APPLICATION, $arTheme;
$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
    "IS_SEF" => "Y",
    "SEF_BASE_URL" => "",
    "IBLOCK_TYPE" => 'prymery_content',
    "IBLOCK_ID" => PRauto::CIBlock_Id('prymery_content','prymery_articles'),
    "DEPTH_LEVEL" => "2",
    "CACHE_TYPE" => "N",
), false, Array('HIDE_ICONS' => 'Y'));
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>