<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if(!$arResult["NavShowAlways"]){
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<ul class="adp-pagination text-right">
    <? if ($arResult["NavPageNomer"] > 1):?>
        <? if($arResult["bSavePage"]):?>
            <li><a class="preview" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">&larr;</a></li>
        <? else:?>
            <? if ($arResult["NavPageNomer"] > 2):?>
                <li><a class="preview" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">&larr;</a></li>
            <? else:?>
                <li><a class="preview" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">&larr;</a></li>
            <? endif?>
        <? endif?>
    <? endif?>

    <? while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
        <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
            <li class="current"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a></li>
        <? elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
            <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a></li>
        <? else:?>
            <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
        <? endif?>
        <? $arResult["nStartPage"]++?>
    <? endwhile?>

    <? if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
        <li><a class="next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">&rarr;</a></li>
    <? endif?>
</ul>

<script type="text/javascript">
$(document).ready(function(){
	$('.nav').css('margin-left',($('#nav_string').width()-$('.nav').width())/2+'px');
});
</script>