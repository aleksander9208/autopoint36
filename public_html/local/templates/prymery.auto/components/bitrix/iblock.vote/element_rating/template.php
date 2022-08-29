<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$frame = $this->createFrame()->begin();?>
<?
if($arParams["DISPLAY_AS_RATING"] == "vote_avg")
{
    if($arResult["PROPERTIES"]["vote_count"]["VALUE"])
        $DISPLAY_VALUE = round($arResult["PROPERTIES"]["vote_sum"]["VALUE"]/$arResult["PROPERTIES"]["vote_count"]["VALUE"], 2);
    else
        $DISPLAY_VALUE = 0;
}
else
    $DISPLAY_VALUE = $arResult["PROPERTIES"]["rating"]["VALUE"];

?>
<ul class="product__rating rating-stars d-inline-flex">
    <?if($arResult["VOTED"] || $arParams["READ_ONLY"]==="Y"):?>
        <?if($DISPLAY_VALUE):?>
            <?foreach($arResult["VOTE_NAMES"] as $i=>$name):?>
                <?if(round($DISPLAY_VALUE) > $i):?>
                    <li><span class="text-primary"><i class="prymery-icon icon-star"></i></span></li>
                <?else:?>
                    <li><span class="text-secondary"><i class="prymery-icon icon-star-outline"></i></span></li>
                <?endif?>
            <?endforeach?>
        <?else:?>
            <?foreach($arResult["VOTE_NAMES"] as $i=>$name):?>
                <td><div class="star" title="<?echo $name?>"></div></td>
            <?endforeach?>
        <?endif?>
    <?else:
        $onclick = "voteScript.do_vote(this, 'vote_".$arResult["ID"]."', ".$arResult["AJAX_PARAMS"].")";
        ?>
        <?if($DISPLAY_VALUE):?>
        <?foreach($arResult["VOTE_NAMES"] as $i=>$name):?>
            <?if(round($DISPLAY_VALUE) > $i):?>
                <li class="star-active star-voted"><span class="text-primary"><i class="prymery-icon icon-star"></i></span></li>
            <?else:?>
                <li class="star-active star-empty"><span class="text-secondary"><i class="prymery-icon icon-star-outline"></i></span></li>
            <?endif?>
        <?endforeach?>
    <?else:?>
        <?foreach($arResult["VOTE_NAMES"] as $i=>$name):?>
            <li class="star-active star-empty"><span class="text-secondary"><i class="prymery-icon icon-star-outline"></i></span></li>
        <?endforeach?>
    <?endif?>
    <?endif?>
</ul>