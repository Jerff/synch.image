<?php

namespace Synch\Image;

use CIBlockElement,
    Bitrix\Main\Loader;

class Replace {

    static public function findImage($articulList) {
        $arFilter = array(
            "IBLOCK_ID" => IBLOCK_OFFERS_ID,
            'PROPERTY_ARTIKUL_POSTAVSHCHIKA' => $articulList,
        );
        $articulList = array_combine($articulList, $articulList);
        if (Loader::includeModule('iblock')) {
            $arSort = array("SORT" => "ASC", 'NAME' => 'ASC');
            $arSelect = array('ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_PICTURE', 'PROPERTY_SHOW', 'PROPERTY_CML2_LINK', 'PROPERTY_ARTIKUL_POSTAVSHCHIKA', 'PROPERTY_TSVET');
            $res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
            while ($arFields = $res->Fetch()) {
                unset($articulList[$arFields['PROPERTY_ARTIKUL_POSTAVSHCHIKA_VALUE']]);
                Element::findImage($arFields);
            }
            if ($articulList) {
                Replace\Logs::add('<font style="color:red;">Не найдены артикулы</font>: ' . implode(', ', $articulList));
            }
        }
    }

}
