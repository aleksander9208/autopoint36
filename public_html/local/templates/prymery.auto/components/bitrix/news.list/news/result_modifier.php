<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['ITEMS']){
    foreach ($arResult['ITEMS'] as $key=>$arItem){
        $Resize = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>350, 'height'=>230), BX_RESIZE_IMAGE_EXACT, true);
        $arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $Resize['src'];
    }
}