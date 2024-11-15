<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 
$this->setFrameMode(true);?>


<?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
<?endif;?>
	
<div class="article-list">

        <?php foreach ($arResult["ITEMS"] as $arItem): ?>

        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

	<a id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="article-item article-list__item" href="<?= $arItem["DETAIL_PAGE_URL"]; ?>"
                                 data-anim="anim-3">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
	 	<div class="article-item__background"><img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"]; ?>" alt=""<?= $arItem["NAME"]; ?>/></div>
	<? endif; ?>

	<div class="article-item__wrapper">
	<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
	    <div class="article-item__title"><?= $arItem["NAME"]; ?></div>
	<? endif ?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
            <div class="article-item__content"><?= $arItem["PREVIEW_TEXT"]; ?></div>
	<? endif; ?>
	</div>
    	</a>

 <?php endforeach; ?>
</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <br /><?=$arResult["NAV_STRING"]?>
<?endif;?>

