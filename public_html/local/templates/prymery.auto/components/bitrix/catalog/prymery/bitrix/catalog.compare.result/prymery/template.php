<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$isAjax = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$isAjax = (
		(isset($_POST['ajax_action']) && $_POST['ajax_action'] == 'Y')
		|| (isset($_POST['compare_result_reload']) && $_POST['compare_result_reload'] == 'Y')
	);
}

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => $arParams['TEMPLATE_THEME']
);

?>
<div class="catalog-compare mb-4 bx-<? echo $templateData['TEMPLATE_CLASS']; ?>" id="bx_catalog_compare_block"><?
	if ($isAjax)
	{
		$APPLICATION->RestartBuffer();
	}
	?>
	<div class="mb-3 d-flex align-items-center">
		<div class="pr-2">
			<a
				class="btn btn-sm <? echo (!$arResult["DIFFERENT"] ? 'btn-secondary' : 'btn-primary'); ?>"
				href="<? echo $arResult['COMPARE_URL_TEMPLATE'].'DIFFERENT=N'; ?>"
				rel="nofollow"><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?></a>
		</div>
		<div class="pr-2">
			<a
				class="btn btn-sm <? echo ($arResult["DIFFERENT"] ? 'btn-secondary' : 'btn-primary'); ?>"
				href="<? echo $arResult['COMPARE_URL_TEMPLATE'].'DIFFERENT=Y'; ?>"
				rel="nofollow"><?=GetMessage("CATALOG_ONLY_DIFFERENT")?></a>
		</div>
	</div>
	<div class="catalog-compare-table table-responsive">
		<table class="table">
			<? if (!empty($arResult["SHOW_FIELDS"]))
			{
				foreach ($arResult["SHOW_FIELDS"] as $code => $arProp)
				{
					$showRow = true;
					if ((!isset($arResult['FIELDS_REQUIRED'][$code]) || $arResult['DIFFERENT']) && count($arResult["ITEMS"]) > 1)
					{
						$arCompare = array();
						foreach($arResult["ITEMS"] as $arElement)
						{
							$arPropertyValue = $arElement["FIELDS"][$code];
							if (is_array($arPropertyValue))
							{
								sort($arPropertyValue);
								$arPropertyValue = implode(" / ", $arPropertyValue);
							}
							$arCompare[] = $arPropertyValue;
						}
						unset($arElement);
						$showRow = (count(array_unique($arCompare)) > 1);
					}
					if ($showRow)
					{
						?>
						<tr>
							<th></th>
							<? foreach($arResult["ITEMS"] as $arElement)
							{
								?>
								<td>
									<? switch($code)
									{
                                        case "NAME":
                                            continue;
										case "PREVIEW_PICTURE":
										case "DETAIL_PICTURE":
											if (!empty($arElement["FIELDS"][$code]) && is_array($arElement["FIELDS"][$code])):?>
                                            <div class="product__picture">
                                                <a class="product__delete text-danger" onclick="CatalogCompareObj.delete('<?=CUtil::JSEscape($arElement['~DELETE_URL'])?>');" href="javascript:void(0)">
                                                    <span class="icon"><i class="icon-times"></i></span>
                                                </a>
                                                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
                                                    <img
                                                            border="0"
                                                            src="<?=$arElement["FIELDS"][$code]["SRC"]?>"
                                                            class="catalog-compare-item-image"
                                                            alt="<?=$arElement["FIELDS"][$code]["ALT"]?>"
                                                            title="<?=$arElement["FIELDS"][$code]["TITLE"]?>"
                                                    />
                                                </a>
                                            </div>
                                                <div class="product__title">
                                                    <a class="catalog-compare-item-title" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement['NAME']?></a>
                                                </div>
											<?endif;
											break;
										default:
											echo $arElement["FIELDS"][$code];
											break;
									}
									?>
								</td>
								<?
							}
							unset($arElement);
							?>
						</tr>
						<?
					}
				}
			}

			if (!empty($arResult["SHOW_OFFER_FIELDS"]))
			{
				foreach ($arResult["SHOW_OFFER_FIELDS"] as $code => $arProp)
				{
					$showRow = true;
					if ($arResult['DIFFERENT'])
					{
						$arCompare = array();
						foreach($arResult["ITEMS"] as $arElement)
						{
							$Value = $arElement["OFFER_FIELDS"][$code];
							if(is_array($Value))
							{
								sort($Value);
								$Value = implode(" / ", $Value);
							}
							$arCompare[] = $Value;
						}
						unset($arElement);
						$showRow = (count(array_unique($arCompare)) > 1);
					}
					if ($showRow)
					{
						?>
						<tr>
							<th></th>
							<?foreach($arResult["ITEMS"] as $arElement)
							{
								?>
								<td>
									<? switch ($code)
									{
										case 'PREVIEW_PICTURE':
										case 'DETAIL_PICTURE':
											if (!empty($arElement["OFFER_FIELDS"][$code]) && is_array($arElement["OFFER_FIELDS"][$code]))
											{
												?>
												<img
													border="0"
													src="<?= $arElement["OFFER_FIELDS"][$code]["SRC"] ?>"
													width="auto"
													height="150"
													alt="<?= $arElement["OFFER_FIELDS"][$code]["ALT"] ?>" title="<?= $arElement["OFFER_FIELDS"][$code]["TITLE"] ?>"
												/><?
											}
											break;
										default:
											?><?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code]);
											break;
									}
									?>
								</td>
								<?
							}
							unset($arElement);
							?>
						</tr>
						<?
					}
				}
			}
			?>

			<tr>
				<th><?=GetMessage('CATALOG_COMPARE_PRICE');?></th>
				<? foreach ($arResult["ITEMS"] as $arElement)
				{
					if (isset($arElement['MIN_PRICE']) && is_array($arElement['MIN_PRICE']))
					{
						?>
						<td><? echo $arElement['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></td>
						<?
					}
					elseif (!empty($arElement['PRICE_MATRIX']) && is_array($arElement['PRICE_MATRIX']))
					{
						?>
						<td><?
						$matrix = $arElement['PRICE_MATRIX'];
						$rows = $matrix['ROWS'];
						$rowsCount = count($rows);
						if ($rowsCount > 0)
						{
							?><table class="compare-price"><?
							if (count($rows) > 1)
							{
								foreach ($rows as $index => $rowData)
								{
									if (empty($matrix['MIN_PRICES'][$index]))
										continue;
									if ($rowData['QUANTITY_FROM'] == 0)
										$rowTitle = GetMessage('CP_TPL_CCR_RANGE_TO', array('#TO#' => $rowData['QUANTITY_TO']));
									elseif ($rowData['QUANTITY_TO'] == 0)
										$rowTitle = GetMessage('CP_TPL_CCR_RANGE_FROM', array('#FROM#' => $rowData['QUANTITY_FROM']));
									else
										$rowTitle = GetMessage(
											'CP_TPL_CCR_RANGE_FULL',
											array('#FROM#' => $rowData['QUANTITY_FROM'], '#TO#' => $rowData['QUANTITY_TO'])
										);
									echo '<tr><td>'.$rowTitle.'</td><td>';
									echo \CCurrencyLang::CurrencyFormat($matrix['MIN_PRICES'][$index]['PRICE'], $matrix['MIN_PRICES'][$index]['CURRENCY']);
									echo '</td></tr>';
									unset($rowTitle);
								}
								unset($index, $rowData);
							}
							else
							{
								$currentPrice = current($matrix['MIN_PRICES']);
								echo '<tr><td class="simple">'.\CCurrencyLang::CurrencyFormat($currentPrice['PRICE'], $currentPrice['CURRENCY']).'</td></tr>';
								unset($currentPrice);
							}
							?></table><?
						}
						unset($rowsCount, $rows, $matrix);
						?></td><?
					}
					else
					{
						?><td>&nbsp;</td><?
					}
				}
				unset($arElement);
				?>
			</tr>

			<? if (!empty($arResult["SHOW_PROPERTIES"]))
			{
				foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty)
				{
					$showRow = true;
					if ($arResult['DIFFERENT'])
					{
						$arCompare = array();
						foreach($arResult["ITEMS"] as $arElement)
						{
							$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
							if (is_array($arPropertyValue))
							{
								sort($arPropertyValue);
								$arPropertyValue = implode(" / ", $arPropertyValue);
							}
							$arCompare[] = $arPropertyValue;
						}
						unset($arElement);
						$showRow = (count(array_unique($arCompare)) > 1);
					}

					if ($showRow)
					{
						?>
						<tr>
							<th><?=$arProperty["NAME"]?></th>
							<?foreach($arResult["ITEMS"] as $arElement)
							{
								?>
								<td>
									<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
								</td>
							<?
							}
							unset($arElement);
							?>
						</tr>
					<?
					}
				}
			}

			if (!empty($arResult["SHOW_OFFER_PROPERTIES"]))
			{
				foreach($arResult["SHOW_OFFER_PROPERTIES"] as $code=>$arProperty)
				{
					$showRow = true;
					if ($arResult['DIFFERENT'])
					{
						$arCompare = array();
						foreach($arResult["ITEMS"] as $arElement)
						{
							$arPropertyValue = $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["VALUE"];
							if(is_array($arPropertyValue))
							{
								sort($arPropertyValue);
								$arPropertyValue = implode(" / ", $arPropertyValue);
							}
							$arCompare[] = $arPropertyValue;
						}
						unset($arElement);
						$showRow = (count(array_unique($arCompare)) > 1);
					}
					if ($showRow)
					{
						?>
						<tr>
							<th><?=$arProperty["NAME"]?></th>
							<? foreach($arResult["ITEMS"] as $arElement)
							{
								?>
								<td>
									<?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
								</td>
								<?
							}
							unset($arElement);
							?>
						</tr>
						<?
					}
				}
			}
			?>
		</table>
</div>
<?
if ($isAjax)
{
	die();
}
?>
<script type="text/javascript">
	var CatalogCompareObj = new BX.Iblock.Catalog.CompareClass("bx_catalog_compare_block", '<?=CUtil::JSEscape($arResult['~COMPARE_URL_TEMPLATE']); ?>');
</script>