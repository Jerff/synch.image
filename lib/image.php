<?php

namespace Synch\Image;

class Image {

    static public function find($artnumber, $color, $i = 0) {
        $color = $color;
        $photo = self::findFile(true, $artnumber, $color, $i);
        if (empty($photo)) {
            $photo = self::findFile(false, $artnumber, $color, $i);
        }
        return $photo;
    }

    static public function findFile($searchType, $artnumber, $color, $i) {
        if ($searchPost) {
            if ($i) {
                $photo = $artnumber . "_" . $color . "_" . $i . ".jpg";
            } else {
                $photo = $artnumber . "_" . $color . ".jpg";
            }
        } else {
            if ($i) {
                $photo = $artnumber . "_" . $i . ".jpg";
            } else {
                $photo = $artnumber . ".jpg";
            }
        }
        return File::search($photo) ? $photo : false;
    }

}
