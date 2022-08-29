<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['ITEMS']){
    foreach ($arResult['ITEMS'] as $key=>$arItem){
        if($arItem['PROPERTIES']['RESIZE']['VALUE'] == 'Y'){
            $Resize = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>198, 'height'=>55), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            $arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $Resize['src'];
        }
    }
}