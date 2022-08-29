<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['ITEMS']){
    foreach ($arResult['ITEMS'] as $key=>$arItem){
        if($arItem['PROPERTIES']['RESIZE']['VALUE'] == 'Y'){
            $Resize = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>328, 'height'=>362), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            $arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $Resize['src'];
        }
        if($arItem['PROPERTIES']['FULL_BANNER']['VALUE']){
            $arResult['ITEMS'][$key]['FULL_BANNER'] = CFile::GetPath($arItem['PROPERTIES']['FULL_BANNER']['VALUE']);
        }
    }
}