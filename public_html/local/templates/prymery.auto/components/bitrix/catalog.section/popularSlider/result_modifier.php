<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['ITEMS'] as $key=>$arItem){
    $Resize = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>191, 'height'=>191), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $Resize['src'];
}

