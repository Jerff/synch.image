<?php

namespace Synch\Image;

use CIBlockElement,
    Bitrix\Main\Loader;

class Search {

    static public function findElement($arFilter, $arNavParams = false) {
        $isSearch = false;
        if (Loader::includeModule('iblock')) {
            $arSort = array("SORT" => "ASC", 'NAME' => 'ASC');
            $arSelect = array('ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_PICTURE', 'PROPERTY_SHOW', 'PROPERTY_CML2_LINK', 'PROPERTY_ARTIKUL_POSTAVSHCHIKA', 'PROPERTY_TSVET');
            $res = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);
            while ($arFields = $res->Fetch()) {
                $isSearch = true;
                Element::findImage($arFields);
            }
        }
        return $isSearch;
    }

}
