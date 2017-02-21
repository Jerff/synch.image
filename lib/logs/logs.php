<?php

namespace Synch\Image\Logs;

use Bitrix\Main\Entity\DataManager,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Type\DateTime,
    Synch\Image\Settings;

Loc::loadMessages(__FILE__);

/**
 * Модель новостей.
 */
class LogsTable extends DataManager {

    /**
     * {@inheritdoc}
     */
    public static function getTableName() {
        return 'd_classylook_image_logs';
    }

    /**
     * {@inheritdoc}
     */
    public static function getMap() {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
            ),
            'DATE_CREATE' => array(
                'data_type' => 'datetime',
                'title' => Loc::getMessage('DEMO_AH_NEWS_DATE_CREATE'),
                'default_value' => new DateTime()
            ),
            'CREATED_BY' => array(
                'data_type' => 'integer',
                'title' => Loc::getMessage('DEMO_AH_NEWS_CREATED_BY'),
                'default_value' => static::getUserId()
            ),
            'TITLE' => array(
                'data_type' => 'string',
                'title' => Loc::getMessage('DEMO_AH_NEWS_TITLE'),
                'default_value' => static::getTitle()
            ),
            'TEXT' => array(
                'data_type' => 'text',
                'title' => Loc::getMessage('DEMO_AH_NEWS_TEXT')
            ),
            'TEXT_TEXT_TYPE' => array(
                'data_type' => 'string'
            )
        );
    }

    public static function getUserId() {
        global $USER;
        return $USER ? $USER->GetID() : null;
    }

    public static function getTitle() {
        return Settings::getMode() == 'upload' ? 'Загрузка: нет фото' : 'Замена: нет фото';
    }

    public static function getFilePath() {
        return __FILE__;
    }

}
