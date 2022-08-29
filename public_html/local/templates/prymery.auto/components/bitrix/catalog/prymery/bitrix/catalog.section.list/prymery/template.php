<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$this->setFrameMode(true);
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if (0 < $arResult["SECTIONS_COUNT"]) : ?>
    <div class="sections">
        <div class="row">
            <? 
            sort($arResult['SECTIONS']);
            foreach ($arResult['SECTIONS'] as $arSection) : ?>
                <?
                $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                ?>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <a class="sections__item"
                       href="<?= $arSection["SECTION_PAGE_URL"]; ?>"
                       id="<?= $this->GetEditAreaId($arSection['ID']); ?>"
                       title="<?= $arSection["NAME"] ?>"
                       style="background-image: url(<?= $arSection["PICTURE"]["SRC"] ?>);">
					   
                        <!-- <div class="sections__info col-8 col-sm-8 col-md-6 col-lg-6 col-xl-6"> -->
                        <div class="sections__info col-8 col-sm-8">
                            <div class="sections__name"><?= $arSection["NAME"] ?></div>
                            <!-- <div class="sections__description"><?//= $arSection["~DESCRIPTION"] ?></div> -->
                            <span class="more"><?=GetMessage('SECTIONS_MORE');?></span>
                        </div>
                    </a>
                </div>
            <? endforeach ?>
        </div>
    </div>
<? endif ?>