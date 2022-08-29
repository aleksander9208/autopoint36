<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
global $compareIds;
foreach ($arResult['ITEMS'] as $key=>$arItem){
    $Resize = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>233, 'height'=>155), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $arResult['ITEMS'][$key]['PREVIEW_PICTURE']['SRC'] = $Resize['src'];

    $arResult['ITEMS'][$key]['ALL_OFFERS_QUANTITY'] = 0;
    if($arItem['OFFERS']){
        foreach ($arItem['OFFERS'] as $offer){
            $arResult['ITEMS'][$key]['ALL_OFFERS_QUANTITY'] =+ $offer['CATALOG_QUANTITY'];
            if($offer['MIN_PRICE']['DISCOUNT_VALUE_VAT'] < $arResult['ITEMS'][$key]['MIN_PRICE_NEW_VAT'] || !$arResult['ITEMS'][$key]['MIN_PRICE_NEW_VAT']){
                $arResult['ITEMS'][$key]['MIN_PRICE_NEW_VAT'] = $offer['MIN_PRICE']['DISCOUNT_VALUE_VAT'];
                $arResult['ITEMS'][$key]['MIN_PRICE_NEW_PRINT_VAT'] = $offer['MIN_PRICE']['PRINT_DISCOUNT_VALUE_VAT'];
            }
            if($offer['MIN_PRICE']['VALUE_VAT'] < $arResult['ITEMS'][$key]['MIN_PRICE_OLD_VAT'] || !$arResult['ITEMS'][$key]['MIN_PRICE_OLD_VAT']){
                $arResult['ITEMS'][$key]['MIN_PRICE_OLD_VAT'] = $offer['MIN_PRICE']['VALUE_VAT'];
                $arResult['ITEMS'][$key]['MIN_PRICE_OLD_PRINT_VAT'] = $offer['MIN_PRICE']['PRINT_VALUE_VAT'];
            }
            if($offer['DISPLAY_PROPERTIES']){
                foreach ($offer['DISPLAY_PROPERTIES'] as $prop){
                    $arResult['ITEMS'][$key]['SKU_PROPS'][$prop['CODE']]['NAME'] = $prop['NAME'];
                    $arResult['ITEMS'][$key]['SKU_PROPS'][$prop['CODE']]['VALUE'][$prop['VALUE']] = $prop['VALUE'];
                }
            }
        }
    }
}

if($arSectionId){
    \Bitrix\Main\Loader::includeModule('iblock');
    $rsSection = \Bitrix\Iblock\SectionTable::getList(array(
        'filter' => array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ID' => $arSectionId,
        ),
        'select' =>  array('ID','CODE','NAME'),
    ));

    while ($arSection=$rsSection->fetch())
    {
        $arResult['SECTIONS'][$arSection['ID']]['INFO'] = $arSection;
    }
}
