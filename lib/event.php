<?php

namespace Synch\Image;

use CIBlockProperty;

class Event {

    static $is = false;

    static public function isOn() {
        if (self::$is) {
            return false;
        } else {
            self::$is = true;
            return true;
        }
    }

    static public function isOff() {
        self::$is = false;
    }

    static public function OnAfterIBlockElementUpdate($arFields) {
        if (self::isOn()) {
            if (
                    !empty($arFields['RESULT'])
                    and ! empty($arFields['ID'])
                    and Settings::IBLOCK_OFFERS_ID == $arFields['IBLOCK_ID']
            ) {
                Search::findElement([
                    "IBLOCK_ID" => IBLOCK_OFFERS_ID,
                    'ID' => $arFields['ID'],
                    'PREVIEW_PICTURE' => false
                ]);
            }
            self::isOff();
        }
    }

    static public function OnBeforeIBlockElementUpdate(&$arFields) {
        if (self::isOn()) {
            if (
                    !empty($arFields['ID'])
                    and ( Settings::IBLOCK_PRODUCT_ID == $arFields['IBLOCK_ID']
                    or Settings::IBLOCK_OFFERS_ID == $arFields['IBLOCK_ID'])
            ) {
                if (isset($arFields['PROPERTY_VALUES'])) {
                    $properties = CIBlockProperty::GetList(Array(), Array("IBLOCK_ID" => $arFields['IBLOCK_ID'], 'CODE' => 'SHOW'));
                    $arFields['ACTIVE'] = 'N';
                    if ($element = $properties->Fetch()) {
                        if (isset($arFields['PROPERTY_VALUES'][$element['ID']][0]['VALUE']) and $arFields['PROPERTY_VALUES'][$element['ID']][0]['VALUE']) {
                            $arFields['ACTIVE'] = 'Y';
                        }
                    }
                } else {
                    unset($arFields['ACTIVE']);
                }
            }
            self::isOff();
        }
    }

}
