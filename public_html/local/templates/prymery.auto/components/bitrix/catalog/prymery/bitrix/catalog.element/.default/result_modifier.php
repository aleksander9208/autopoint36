<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['DETAIL_PICTURE']){
    $arResult["DETAIL_PICTURE"]['RESIZE']['REAL'] = $arResult['DETAIL_PICTURE']['SRC'];
    $arResult["DETAIL_PICTURE"]['RESIZE']['BIG'] = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>450, 'height'=>300), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $arResult["DETAIL_PICTURE"]['RESIZE']['SMALL'] = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>60, 'height'=>60), BX_RESIZE_IMAGE_PROPORTIONAL, true);
}
if($arResult['PROPERTIES']['PHOTOS']['VALUE']){
    foreach($arResult["PROPERTIES"]["PHOTOS"]["VALUE"] as $key => $value)
    {
        $arResult["PHOTOS"][$key]['REAL'] = CFile::GetPath($value);
        $arResult["PHOTOS"][$key]['BIG'] = CFile::ResizeImageGet($value, array('width'=>450, 'height'=>300), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $arResult["PHOTOS"][$key]['SMALL'] = CFile::ResizeImageGet($value, array('width'=>60, 'height'=>60), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $arResult["PHOTOS"][$key]['DESCRIPTION'] = $arResult["PROPERTIES"]["ADDITIONAL_PHOTO"]["DESCRIPTION"][$key];
    }
}

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();