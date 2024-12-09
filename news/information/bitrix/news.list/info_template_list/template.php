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
$this->setFrameMode(true);
?>

<?php if (!empty($arResult["ITEMS"])): ?>
    
    <div class="article-card">
        <div>
            <?php foreach ($arResult["SECTIONS"] as $section): ?>
                <a class="article-card__button" href="<?= $arResult["ITEMS"][0]["LIST_PAGE_URL"] . $section["CODE"] ?>/">
                    <?= $section["CODE"] ?>
                </a>
            <?php endforeach; ?>
        </div>
        <br>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>

            <div class="article-card__title" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                        <?echo $arItem["NAME"]?>
                    <?else:?>
                        <b><?echo $arItem["NAME"]?></b><br />
                    <?endif;?>
                <?endif;?>
            </div>

            <div class="article-card__date">
                <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                    <span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
                <?endif?>
            </div>
        
            <div class="article-card__content">
                <div class="article-card__image sticky">
                    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
                            src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                            width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                            height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                            /></a>
                        <?endif;?>
                    <?endif?>
                </div>
            
                <div class="article-card__text">
                    <div class="block-content" data-anim="anim-3">
                    <p>
                        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                            <?echo $arItem["PREVIEW_TEXT"];?>
                        <?endif;?>
                    </p>
                    </div>
                     <a class="article-card__button" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?=GetMessage("T_NEWS_DETAIL")?></a></div>
                </div>
            </div>
        <?endforeach;?>
    </div>
<?php endif; ?>
