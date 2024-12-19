<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
if (!$USER->IsAdmin()) {
    LocalRedirect('/');
}
\Bitrix\Main\Loader::includeModule('iblock');

$IBLOCK_ID = 28;
$el = new CIBlockElement;

function getPropEnumList($IBLOCK_ID){
    $arProps = [];
    $rsProp = CIBlockPropertyEnum::GetList(
        ["SORT" => "ASC", "VALUE" => "ASC"],
        ['IBLOCK_ID' => $IBLOCK_ID]
    );
    while ($arProp = $rsProp->Fetch()) {
        $key = trim($arProp['VALUE']);
        $arProps[$arProp['PROPERTY_CODE']][$key] = $arProp['ID'];
    } 
	
    return $arProps;
}

function deleteElements($IBLOCK_ID){
    $rsElements = CIBlockElement::GetList([], ['IBLOCK_ID' => $IBLOCK_ID], false, false, ['ID']);
    while ($element = $rsElements->GetNext()) {
        CIBlockElement::Delete($element['ID']);
    }
}

function propsArrayCsv() {
    $props = [];
    $row = 1;
    if (($handle = fopen("vacancy.csv", "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if ($row == 1) {
                $row++;
                continue;
            }
            $props[] = [
                'ACTIVITY' => $data[9],
                'FIELD' => $data[11],
                'OFFICE' => $data[1],
                'LOCATION' => $data[2],
                'REQUIRE' => $data[4],
                'DUTY' => $data[5],
                'CONDITIONS' => $data[6],
                'EMAIL' => $data[12],
                'DATE' => date('d.m.Y'),
                'TYPE' => $data[8],
                'SALARY_TYPE' => '',
                'SALARY_VALUE' => $data[7],
                'SCHEDULE' => $data[10],
                'NAME' => $data[3],
	    	'END' => $data[14]
	    ];
            $row++;
        }
        fclose($handle);
    }
    return $props;
}

function addEnumValueToList($value, &$arProps, $key, $IBLOCK_ID) {
    $rsProperty = CIBlockProperty::GetList([], ['CODE' => $key, 'IBLOCK_ID' => $IBLOCK_ID]);
    
    if ($arProperty = $rsProperty->Fetch()) {
        $propertyId = $arProperty['ID'];
        
        $rsEnum = CIBlockPropertyEnum::GetList([], ['PROPERTY_ID' => $propertyId, 'VALUE' => $value]);
        
        if (!$arEnum = $rsEnum->Fetch()) {
            $enum = new CIBlockPropertyEnum();
            $arFields = [
                'PROPERTY_ID' => $propertyId,
                'VALUE' => $value,
                'SORT' => 500,
            ];

            if ($propId = $enum->Add($arFields)) {
                echo "Значение '{$value}' успешно добавлено в список.";
                $arProps[$key][$value] = $propId;
                return $propId;
            } else {
                echo "Ошибка добавления: " . $enum->LAST_ERROR;
                return false;
            }
        } else {
            return $arEnum['ID'];
        }
    }
    
    return false; 
}

function addProductToIblock($iblockId, $props, $userId) {
    $el = new CIBlockElement();
    
    $arLoadProductArray = [
        "MODIFIED_BY" => $userId,
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID" => $iblockId,
        "PROPERTY_VALUES" => $props,
        "NAME" => $props['NAME'],
        "ACTIVE" => $props['END'] ? 'Y' : 'N',
    ];

    if ($productId = $el->Add($arLoadProductArray)) {
        return "Добавлен элемент с ID : " . $productId;
    } else {
        return "Error: " . $el->LAST_ERROR;
    }
}

function handleProps($props, $arProps, $IBLOCK_ID, $userId) {
    foreach ($props as $tProps) {
        foreach ($tProps as $key => &$value) {
            $value = trim($value);
            $value = str_replace('\n', '', $value);
            if (stripos($value, '•') !== false) {
                $value = explode('•', $value);
                array_splice($value, 0, 1);
                foreach ($value as &$str) {
                    $str = trim($str);
                }
            } elseif (isset($arProps[$key])) {
                $arSimilar = [];
                $propValueKeys = ['ACTIVITY', 'FIELD', 'LOCATION', 'TYPE', 'SCHEDULE'];
                foreach ($arProps[$key] as $propKey => $propVal) {
                    if ($key == 'OFFICE') {
                        $value = mb_strtolower($value, 'UTF-8');
                        $arSimilar[similar_text($propKey, $value)] = $propVal;
                    }
                    if (stripos($propKey, $value) !== false) {
                        $value = $propVal;
                        break;
                    }

                    if (similar_text($propKey, $value) > 50) {
                        $value = $propVal;
                    }
                }
                foreach ($propValueKeys as $check) {
                    if ($key == $check && !is_numeric($value)) {
                        echo "check: " . $value . "<br>";
                        $value = addEnumValueToList($value, $arProps, $key, $IBLOCK_ID);
                    }
                }

                if ($key == 'OFFICE' && !is_numeric($value)) {
                    ksort($arSimilar);
                    $a = array_pop($arSimilar);
                    $value = $a;
                }

                if ($key == 'SALARY_VALUE') {
                    if ($value == '-') {
                        $value = '';
                    } elseif ($value == 'по договоренности') {
                        $value = '';
                        $tProps['SALARY_TYPE'] = $arProps['SALARY_TYPE']['договорная'] ?? '';
                    } else {
                        $arSalary = explode(' ', $value);
                        if ($arSalary[0] == 'от' || $arSalary[0] == 'до') {
                            $tProps['SALARY_TYPE'] = $arProps['SALARY_TYPE'][$arSalary[0]] ?? '';
                            array_splice($arSalary, 0, 1);
                            $value = implode(' ', $arSalary);
                        } else {
                            $tProps['SALARY_TYPE'] = $arProps['SALARY_TYPE']['='] ?? '';
                        }
                    }
                }
            }
        }

        $result = addProductToIblock($IBLOCK_ID, $tProps, $userId);
        echo $result;
    }
}

$arProps = getPropEnumList($IBLOCK_ID); 
deleteElements($IBLOCK_ID);
$props = propsArrayCsv();
handleProps($props, $arProps, $IBLOCK_ID, $USER->GetID());	
