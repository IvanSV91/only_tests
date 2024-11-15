<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 


$this->setFrameMode(true);?>
<?php
$APPLICATION->SetAdditionalCSS("/bitrix/components/bitrix/news.list/templates/test/common.css");

//$themeClass = $arParams['TEMPLATE_THEME'];
//echo $themeClass;

?>		

<div id="barba-wrapper">
    <?php if ($arResult["ITEMS"]): ?>

         <?php foreach ($arResult["ITEMS"] as $arItem): ?>
		 
		<a class="article-item article-list__item" href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
				 data-anim="anim-3">
			<?php if (!empty($arItem["PREVIEW_PICTURE"])):
                            // Получаем URL изображения
                            $imgSrc = ($arItem["PREVIEW_PICTURE"]["SRC"]); ?>

		  <div class="article-item__background"><img src="<?= $imgSrc ?>" alt="<?= $arItem["NAME"] ?>"
                                                   data-src="<?= $imgSrc ?>" />
						   </div>
	<?php endif; ?>


		<div class="article-item__wrapper">
			<div class="article-item__title">
                        <?= $arItem["NAME"] ?></div>
			<div class="article-item__content"><?= $arItem["PREVIEW_TEXT"] ?></div>
                        </div>
                    </div></a>
            <?php endforeach; ?>
<?php else: ?>
        <p>Новостей нет.</p>
    <?php endif; ?>
</div>
