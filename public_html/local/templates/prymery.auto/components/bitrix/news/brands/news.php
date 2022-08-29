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
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');
	
$this->setFrameMode(true);

$arFilter = array("IBLOCK_ID"=>2,'ACTIVE'=>"Y");
$res = CIBlockElement::GetList(array('NAME'=>'ASC'), $arFilter, false, false, array('*'));
while($el = $res->getNext()) {
		
	// if (in_array($el['NAME'],$skip)) continue;
	// if (strpos($el['NAME'],'Сертификат')!==false) continue;
	// if (strpos($el['NAME'],'№')!==false) continue;
  
	// $arFilter = array(
		// "IBLOCK_ID" => 8,
		// "CATALOG_AVAILABLE" => "Y",
		// "PROPERTY_CML2_MANUFACTURER_VALUE" => $el['NAME']
	// );
	
	// $arSelect = array(
		// "ID", "NAME", "CODE", "DETAIL_PAGE_URL", 
		// "IBLOCK_SECTION_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE",
		// "PROPERTY_*"
	// );

	// $arElements = xTools::GetList($arFilter, $arSelect);
	
	// if(!count($arElements)) continue;
	
	// echo "<pre style='disp2lay: none;' alt='arElements'>";
	// print_r($arElements); 
	// echo "</pre>";

	$BUK[strtoupper(substr($el['NAME']))][]=$el;
	// $BUK[]=$el['NAME']; 
	
	// echo "<pre style='disp2lay: none;' alt='BUK'>";
	// print_r($BUK); 
	// echo "</pre>";

}
?>

<div class="page-root__content">
	<div class="content">
		<div class="content__inner">
			<div class="brands-page">
				<div class="brands-page__wrap wrap_l wrap_center content__wrap">
					<div class="brands-page__content">
						<div class="brands">

							<div class="brands__section brands__section_all">
								<div class="brands__body brands__body_alph">
									<!-- <a href="#TOP">топ бренды</a> -->
								  <? ksort($BUK);
								  foreach($BUK as $B=>$BRANDS){
									?>
									  <a href="#<?=$B?>"><?=$B?></a>
								  <?}?>
								</div>
							</div>

							<div class="brands__section-wrap">
						  <?
						  foreach($BUK as $B=>$BRANDS){
							?>

						
									<div class="brands__section" id="<?=$B?>">
										<p class="brands__title"><?=$B?></p>
										<div class="brands__body">

										<? foreach($BRANDS as $brand){
											
											$hlblock = HL\HighloadBlockTable::getById(4)->fetch(); // id highload блока
											$entity = HL\HighloadBlockTable::compileEntity($hlblock);
											$entityClass = $entity->getDataClass();

											$resBrand = $entityClass::getList(array(
												'select' => array('*'),
												'filter' => array('UF_NAME' => $brand["NAME"])
											));

											$rowBrand = $resBrand->fetch();											
											
											// echo "<pre style='display: none;' alt='rowBrand'>";
											// print_r($brand);
											// echo "</pre>";	
	
										// if (!$brand['PREVIEW_PICTURE']) continue;
											$brand['PREVIEW_PICTURE']=CFile::GetFileArray($brand['PREVIEW_PICTURE']);

											?>
										<? if($brand['PREVIEW_PICTURE']['SRC']){ ?>
											<div class="brands__one brands__one_pic">
												<img src="<?= $brand['PREVIEW_PICTURE']['SRC'] ?>">
												<a href="/catalog/?brand=<?=$brand["NAME"]?>">
													<p class="blog-item__title"><?=$brand["NAME"]?></p>
												</a>
											</div>
										<? } else { ?>
											<div class="brands__one">
												<a href="/catalog/?brand=<?=$brand["NAME"]?>">
													<p class="blog-item__title"><?=$brand["NAME"]?></p>
												</a>
											</div>
										<? } // if ?>
											
										<?} // foreach ?>

										</div>
									</div>
						  <?}?>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>