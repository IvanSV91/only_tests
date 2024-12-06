<?php
$arFilter = array(
    'IBLOCK_ID' => 7,
    'ACTIVE' => 'Y', 
);
$arSelect = array('ID', 'CODE'); 

$res = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilter, true, $arSelect);
$arResult["SECTIONS"] = array(); // Инициализация массива

while ($section = $res->Fetch()) {
    $arResult["SECTIONS"][] = array(
        'ID' => $section['ID'],
        'CODE' => $section['CODE'],
    );
}
?>

