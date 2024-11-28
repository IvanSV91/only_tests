<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["isFormErrors"] == "Y") {
    if(!empty($arResult["FORM_ERRORS"]["EMAIL"])){
        $arResult["FORM_ERRORS"]["EMAIL"] = "Неверный формат почты";
    }
    if(!empty($arResult["FORM_ERRORS"]["NAME"])){
        $arResult["FORM_ERRORS"]["NAME"] = "Поле должно содержать не менее 3-х символов";
    } 
    if(!empty($arResult["FORM_ERRORS"]["COMPANY"])){
        $arResult["FORM_ERRORS"]["COMPANY"] = "Поле должно содержать не менее 3-х символов";
    }     
}


$arResult['getInputHtml'] = function($question, $isErrors) {
    $id = $question['STRUCTURE'][0]['ID'];
    $type = $question['STRUCTURE'][0]['FIELD_TYPE'];
    $name = "form_{$type}_{$id}";
    $errors = $isErrors;
    switch ($name)
    {
        case 'form_text_1':
            $input = '<input type="text" class="input__input ' . ($errors == "Y" ? 'invalid' : '') . '" name="form_text_1" id="1"/>';
        break; 

        case 'form_text_2':
            $input = '<input type="text" class="input__input ' . ($errors == "Y" ? 'invalid' : '') . '" name="form_text_2" id="2"/>';
        break; 

        case 'form_email_3':
            $input = '<input type="email" class="input__input ' . ($errors == "Y" ? 'invalid' : '') . '" name="form_email_3" id="3"/>';
        break;

        case 'form_text_4':
            $input = '<input class="input__input" type="tel" id="4" data-inputmask="\'mask\': \'+79999999999\', \'clearIncomplete\': \'true\'" maxlength="12" x-autocompletetype="phone-full" name="form_text_4" value="" required="" />';
        break;
        
    }

    return $input;
};
?>
