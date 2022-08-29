<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['DETAIL_PICTURE']){
    $Resize = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>375, 'height'=>250), BX_RESIZE_IMAGE_EXACT, true);
    $arResult['DETAIL_PICTURE']['SRC'] = $Resize['src'];
}