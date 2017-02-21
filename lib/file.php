<?php

namespace Synch\Image;

class File {

    static public function getPath($photo) {
        return realpath($_SERVER['DOCUMENT_ROOT'] . '/../Yandex.Disk') . '/' . Settings::getMode() . '/' . $photo;
    }

    static public function search($photo) {
        $is = self::file_exists(self::getPath($photo));
        if (empty($is)) {
            $is = self::searchInFolder($Photo);
        }
        return $is;
    }

    static public function file_exists($photo) {
        static $fileExists = array();
        if (!isset($fileExists[$photo])) {
            $fileExists[$photo] = file_exists($photo);
        }
        return $fileExists[$photo];
    }

    static public function searchInFolder($photo) {
        static $fileMap = array();
        if (empty($fileMap)) {
            $path = self::getPath('');
            foreach (scandir($path) as $file) {
                if ($file == '.' or $file == '..') {
                    continue;
                }
                $name = strtolower(substr($file, 0, strpos($file, '.')));
                $fileMap[$name] = $path . $file;
            }
        }

        $photo = strtolower(substr($photo, 0, strpos($photo, '.')));
        if (isset($fileMap[$photo])) {
            return $fileMap[$photo];
        } else {
            return false;
        }
    }

}
