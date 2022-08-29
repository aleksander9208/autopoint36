<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== TRUE) {
  die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(TRUE);

use Bitrix\Iblock\IblockTable;

$arProds = array();

foreach($_GET as $key => $value){
	if(strstr($key, "arrFilter_127"))
		$arProds[] = $value;
} // foreach

?>
<div class="catalog-page__left-filters">
    <input type="hidden" name="set_filter" class="result-value" value="Y">
    <input type="hidden" name="AJAX_MODE" class="result-value" value="Y">
  <?
  foreach ($arResult["ITEMS"] as $key => $arItem)//prices
  {
    $key = $arItem["ENCODED_ID"];
    if (isset($arItem["PRICE"])):
      if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) {
        continue;
      }

      ?>

        <div class="catalog-page__filter">
            <div class="filter">
                <div class="filter__wrap">
                    <div class="filter__header">
                        <div class="filter__header-wrap">
                            <p>Цена</p>
                            <div class="plus-button"></div>
                        </div>
                    </div>
					
                    <div class="filter__body">
                        <div class="filter__body-wrap">
                            <div class="price-selector price-selector_filter">
                                <div class="price-selector__inputs">
                                    <input name="<?
                                    echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                           id="<?
                                           echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                           value="<?
                                           echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                           class="input result-value"
                                           type="text"
                                           readonly>
                                    <p>-</p>
                                    <input name="<?
                                    echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                           id="<?
                                           echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                           value="<?
                                           echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                           class="input result-value"
                                           type="text"
                                           readonly>
                                </div>
                                <div class="price-selector__line">
                                    <div id="sliderPrice"></div>
                                </div>
                                <script>
                                  $(function () {
                                    $("#sliderPrice").slider({
                                      range: true,
                                      min: <?=$arItem["VALUES"]["MIN"]["VALUE"]?>,
                                      max: <?=$arItem["VALUES"]["MAX"]["VALUE"]?>,
                                      values: [<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"] ?: $arItem["VALUES"]["MIN"]["VALUE"]?>, <?=$arItem["VALUES"]["MAX"]["HTML_VALUE"] ?: $arItem["VALUES"]["MAX"]["VALUE"]?>],
                                      slide: function (event, ui) {
                                        $("#<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>").val(ui.values[0]);
                                        $("#<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>").val(ui.values[1]);
                                      }
                                    });
                                    $("#<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>").val($("#sliderPrice").slider("values", 0));
                                    $("#<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>").val($("#sliderPrice").slider("values", 1));
                                  });
                                </script>
                                <div class="price-selector__btns">
                                    <div class="button-apply">Применить</div>
                                    <div class="button-reset">Сбросить</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endif;
  }
  ?>


  <? foreach ($arResult["ITEMS"] as $key => $arItem) {


    if (
      empty($arItem["VALUES"])
      || isset($arItem["PRICE"])
    ) {
      continue;
    }

    if (
      $arItem["DISPLAY_TYPE"] == "A"
      && (
        $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
      )
    ) {
      continue;
    }
    ?>
      <div class="catalog-page__filter">
      <div class="filter">
      <div class="filter__wrap">
          <div class="filter__header">
              <div class="filter__header-wrap">
                  <p><?= $arItem['NAME'] ?></p>
                  <div class="plus-button"></div>
              </div>
          </div>
          <div class="filter__body">
              <div class="filter__body-wrap">
                <?
                if ($arItem['CODE'] == 'CML2_MANUFACTURER') {
                ?>
                  <div class="search-dlist search-dlist_filter">
                      <div class="search-dlist__input">
                          <input class="input" type="text"
                                 placeholder="Поиск по бренду">
                      </div>
                      <div class="search-dlist__list">
                        <?
                        } ?>
                          <div class="check-list check-list_cat scrollbar-rail">

                            <?
                            $arCur = current($arItem["VALUES"]);
                            

                            foreach ($arItem["VALUES"] as $val => $ar):
								$checked = in_array($val, $arProds) ? ' checked="checked"' : '';
								
								// $ar['CHECKED'] ? ' checked="checked"' : '' 
                            ?>
                                <div class="check-list__one">
                                    <label class="input-checkbox">
                                        <input class="input-checkbox__hide listener-changes result-value"
                                               type="checkbox" data-key="<?=$key?>"
                                               name="<?= $ar["CONTROL_NAME"] ?>"
                                               id="<? echo $ar["CONTROL_ID"] ?>"
                                               value="<?= $val ?>" <?= $checked ?> />
                                        <div class="input-checkbox__text"><?= $ar["VALUE"]; ?></div>
                                    </label>
                                </div>

                            <? endforeach; ?>

                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    <?
    if ($arItem['CODE'] == 'CML2_MANUFACTURER') {
      ?>
        </div>
        </div>
      <?
    } ?>

    <?
  }
  ?>

</div>