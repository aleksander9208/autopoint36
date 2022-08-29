<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?if (!empty($arResult)):?>
<section class="widget widget-catalog">
    <ul>
        <?
        $previousLevel = 0;
        $count_parent = 0;
        foreach($arResult as $k=>$arItem):
        if($count_parent<5):
            ?>
            <?if($arItem["DEPTH_LEVEL"]==1){
                $count_parent++;
                $key = 0;
                $show_more = 0;
                unset($link);
            }?>
                <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                    <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                <?endif?>
                <?if ($arItem["IS_PARENT"]):?>
                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li>
                            <a<? if ($arItem["SELECTED"]):?> class="selected"<?endif;?> href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
                            <ul class="dropdown">
                    <?endif?>
                <?else:
                    $key++;
                    if($key<4):?>
                        <li class="dl-<?=$arItem["DEPTH_LEVEL"]?>"><a<? if ($arItem["SELECTED"]):?> class="selected"<?endif;?> href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a></li>
                    <?elseif($show_more==0):?>
                        <?if($arItem["DEPTH_LEVEL"]!=1){
                            for($i=0;$i<50;$i++){
                                if($arResult[$k-$i]['DEPTH_LEVEL']==1){
                                    $link = $arResult[$k-$i]['LINK'];
                                    break;
                                }
                            }
                        }?>
                        <?if($link):?>
                            <li class="show-more"><a href="<?=$link?>">Показать еще</a></li>
                        <?endif;?>
                        <?$show_more++;?>
                    <?endif?>
                <?endif?>
                <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
            <?endif?>
        <?endforeach?>
        <?if ($previousLevel > 1):?>
            <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
        <?endif?>
    </ul>
</section>
<?endif?>