<?php

namespace Synch\Image\Replace;

use Bitrix\Main\Entity\DataManager,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Type\DateTime;

Loc::loadMessages(__FILE__);

/**
 * Модель новостей.
 */
class ReplaceTable extends DataManager {

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
            'CREATED_BY' => array(
                'data_type' => 'integer',
                'title' => 'Выберите файл',
                'default_value' => static::getUserId()
            )
        );
    }

    public static function add(array $data) {

    }

    /**
     * {@inheritdoc}
     */
    public static function update($primary, array $data) {
        $data['MODIFIED_BY'] = static::getUserId();

        return parent::update($primary, $data);
    }

    /**
     * Возвращает идентификатор пользователя.
     *
     * @return int|null
     */
    public static function getUserId() {
        global $USER;

        return $USER->GetID();
    }

    public static function getFilePath() {
        return __FILE__;
    }

}
