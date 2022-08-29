<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<section class="widget widget-category category-toggle">
<ul>
<?
$previousLevel = 0;
foreach($arResult as $arItem):?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>
	<?if ($arItem["IS_PARENT"]):?>
		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
            <li class="has-dropdown">
                <a<? if ($arItem["SELECTED"]):?> class="selected"<?endif;?> href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?>
                    <span class="icon"><i class="icon-angle-right"></i></span>
                </a>
                <ul class="dropdown">
		<?endif?>
	<?else:?>
        <li><a<? if ($arItem["SELECTED"]):?> class="selected"<?endif;?> href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
<?endforeach?>
<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>
</ul>
</section>
<?endif?>