<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init(['masked_input']); ?>

<?=$arResult["FORM_HEADER"]?>

    <div class="contact-form">
        <div class="contact-form__head">
            <div class="contact-form__head-title">Связаться</div>
            <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и&nbsp;расчет цены с&nbsp;учетом
            ваших требований</div>
        </div>

        <input type="hidden" name="web_form_submit" value="Y">

        <form class="contact-form__form">
            <div class="contact-form__form-inputs">

                <?php foreach (['NAME', 'COMPANY', 'EMAIL', 'PHONE'] as $questionKey): ?>
                    <div class="input contact-form__input">
                        <label class="input__label" for="<?= strtolower($questionKey) ?>">
                            <div class="input__label-text"><?= $arResult["QUESTIONS"][$questionKey]['CAPTION'] ?>
                            <?= ($arResult["QUESTIONS"][$questionKey]['REQUIRED'] === 'Y' ? ' *' : '') ?>:</div>
                            <?= $arResult['getInputHtml']($arResult["QUESTIONS"][$questionKey], $arResult["isFormErrors"]) ?>
                            <?php if ($arResult["isFormErrors"] === "Y"): ?>
                            <div class="input__notification"><?= $arResult["FORM_ERRORS"][$questionKey] ?? ''; ?></div>
                            <?php endif; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                            
            </div>

            <div class="contact-form__form-message">
                <div class="input"><label class="input__label" for="form_textarea_5">
                    <div class="input__label-text"><?=$arResult["QUESTIONS"]['MESSAGE']['CAPTION']?>
                        <?=($arResult["QUESTIONS"]['MESSAGE']['REQUIRED'] === 'Y' ? ' *' : '')?>:</div>
                    <?=$arResult["QUESTIONS"]['MESSAGE']['HTML_CODE']?>
                    <div class="input__notification"></div>    
                </label></div>
            </div>

            <div class="contact-form__bottom">
                <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что
                    ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
                    данных&raquo;.
                </div>

                <?php if (($arResult["isFormNote"] == "Y") && ($_SERVER["REQUEST_METHOD"] == "POST")) : ?>
                    <button class="form-button contact-form__bottom-button success">
                        <div class="form-button__title">Отправлено</div>
                    </button>
                <?php elseif ($arResult["isFormErrors"] == "Y") : ?>
                    <button class="form-button contact-form__bottom-button error">
                        <div class="form-button__title">Ошибка отправки</div>
                    </button>
                <?php else : ?>
                    <button class="form-button contact-form__bottom-button">
                        <div class="form-button__title">Отправить</div>
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>

<script>
    BX.ready(function() {
        var result = new BX.MaskedInput({
            mask: '+79999999999',
            input: BX('4'),
            placeholder: '_'
        });

        BX.bind(result.input.node, 'blur', function() {
            if (!result.checkValue()) {
                result.input.val('');
            }
        });
    });
</script>

<?=$arResult["FORM_FOOTER"]?>
