<?php

namespace Synch\Image;

use CIBlockElement,
    CCatalogSKU,
    CDBResult,
    CFile,
    CTempFile,
    CheckDirPath,
    Bitrix\Main\Application,
    Bitrix\Iblock\ElementTable;

class Element {

    static private function resizeImage($photo, $size) {
        $arFile = CFile::MakeFileArray($photo);
        $size = array(
            "width" => Settings::MORE_PHOTO_WIDTH, // новая ширина
            "height" => Settings::MORE_PHOTO_HEIGHT // новая высота
        );
        if ($arFile) {
            $sourceFile = $arFile["tmp_name"];
            $destinationFile = CTempFile::GetFileName(basename($sourceFile));
            CheckDirPath($destinationFile);
            if (CFile::ResizeImageFile($sourceFile, $destinationFile, $size, Settings::RESIZE_TYPE)) {
                $arFile["tmp_name"] = $destinationFile;
                $arImageSize = CFile::GetImageSize($destinationFile);
                $arFile["type"] = $arImageSize["mime"];
                $arFile["size"] = filesize($arFile["tmp_name"]);
            }
        }
        return $arFile;
    }

    static public function findImage($arFields) {
        Application::getInstance()->getConnection()->startTransaction();

        try {

            $isSearch = false;
            $artnumber = $arFields["PROPERTY_ARTIKUL_POSTAVSHCHIKA_VALUE"];
            $color = $arFields["PROPERTY_TSVET_VALUE"];

            $photo = Image::find($artnumber, $color);
            if ($photo) {
                $isSearch = true;
                ElementTable::update($arFields["ID"], [
                    "PREVIEW_PICTURE" => self::resizeImage($photo, [
                        "width" => Settings::PREVIEW_WIDTH,
                        "height" => Settings::PREVIEW_HEIGHT
                    ]),
                    "DETAIL_PICTURE" => self::resizeImage($photo, [
                        "width" => Settings::DETAIL_WIDTH,
                        "height" => Settings::DETAIL_HEIGHT
                    ])
                ]);
            }

            $i = 1;
            $morePhoto = array();
            while ($photo = Image::find($artnumber, $color, $i)) {
                $morePhoto[] = self::resizeImage($photo, [
                            "width" => Settings::MORE_PHOTO_WIDTH,
                            "height" => Settings::MORE_PHOTO_HEIGHT
                ]);
                $i++;
            }
            if (empty($morePhoto)) {
                if ($photo = Image::find($artnumber, $color, 0)) {
                    $morePhoto[] = self::resizeImage($photo, [
                                "width" => Settings::MORE_PHOTO_WIDTH,
                                "height" => Settings::MORE_PHOTO_HEIGHT
                    ]);
                    $i++;
                }
            }
            if ($morePhoto) {
                CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $morePhoto, 'MORE_PHOTO');
            }
            $name = "(" . $arFields["ID"] . ") " . $arFields['NAME'] . ' - ' . $arFields['PROPERTY_ARTIKUL_POSTAVSHCHIKA_VALUE'];
            if (empty($isSearch)) {
                Logs\LogsTable::add([
                    'TEXT' => $name
                ]);
                Replace\Logs::add('<font style="color:red;">Не загружено фото</font>: ' . $name);
            } else {
                Replace\Logs::add('<font style="color:green;">Загружено фото</font>: ' . $name);
            }

            Application::getInstance()->getConnection()->commitTransaction();
        } catch (Exception $exc) {
            Application::getInstance()->getConnection()->rollbackTransaction();
        }
    }

}
