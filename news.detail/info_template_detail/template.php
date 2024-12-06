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

<div class="article-card">

    <div class="article-card__title">
        <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		    <?=$arResult["NAME"]?>
	    <?endif;?>
    </div>

    <div class="article-card__date">
        <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		    <?=$arResult["DISPLAY_ACTIVE_FROM"]?>
	    <?endif;?>
    </div>

    <div class="article-card__content">
        <div class="article-card__image sticky"> 	
            <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		        <img
			    border="0"
			    src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			    width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			    height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			    alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			    title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
                data-object-fit="cover"
            />
	        <?endif?>
        </div>

        <div class="article-card__text">
            <div class="block-content" data-anim="anim-3">
                <p>
                    <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && ($arResult["FIELDS"]["PREVIEW_TEXT"] ?? '')):?>
		                <?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?>
                        <a class="article-card__button" href="<?= $arResult["LIST_PAGE_URL"]?>"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></div>
                    <?endif;?>
                </p>

                <p>
                    <?if($arResult["DETAIL_TEXT"] <> ''):?>
		                <?echo $arResult["DETAIL_TEXT"];?>
	                <?endif;?>
                </p>
            </div>
            
            <a class="article-card__button" href="<?= $arResult["LIST_PAGE_URL"]?>"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></div>
         </div>
    </div>
</div>
