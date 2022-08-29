<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

foreach($arResult['SECTIONS'] as $key => $arSection){
    if($arSection['PICTURE']) {
        $tempPicture = CFile::ResizeImageGet(
            $arSection['PICTURE'],
            array('width'=>580, 'height'=>185),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
        $arResult['SECTIONS'][$key]['PICTURE']['SRC'] = $tempPicture['src'];
        $arResult['SECTIONS'][$key]['PICTURE']['WIDTH'] = $tempPicture['width'];
        $arResult['SECTIONS'][$key]['PICTURE']['HEIGHT'] = $tempPicture['height'];
    }
}
?>