<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['ITEMS'] as $key=>$arItem){
    if($arItem['PROPERTIES']['NEW_PHOTO']['VALUE']){
        $Resize = CFile::ResizeImageGet($arItem['PROPERTIES']['NEW_PHOTO']['VALUE'], array('width'=>229, 'height'=>185), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $Resize['src'];
    }else{
        $Resize = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>229, 'height'=>185), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $Resize['src'];
    }
}

