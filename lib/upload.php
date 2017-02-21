<?php

namespace Synch\Image;

class Upload {

    static public function start() {
        $arFilter = array(
            "IBLOCK_ID" => IBLOCK_OFFERS_ID,
            'PREVIEW_PICTURE' => false,
        );
        return Search::findElement($arFilter);
    }

}
