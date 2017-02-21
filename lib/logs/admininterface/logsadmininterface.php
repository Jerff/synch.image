<?php

namespace Synch\Image\Logs\AdminInterface;

use Bitrix\Main\Localization\Loc,
    DigitalWand\AdminHelper\Helper\AdminInterface,
 DigitalWand\AdminHelper\Widget\{
    DateTimeWidget,
    FileWidget,
    NumberWidget,
    StringWidget,
    UrlWidget,
    UserWidget,
    VisualEditorWidget
};

Loc::loadMessages(__FILE__);

/**
 * Описание интерфейса (табок и полей) админки новостей.
 *
 * {@inheritdoc}
 */
class LogsAdminInterface extends AdminInterface {

    /**
     * {@inheritdoc}
     */
    public function fields() {
        return array(
            'MAIN' => array(
                'NAME' => Loc::getMessage('SYNCH_IMAGE_Logs'),
                'FIELDS' => array(
                    'ID' => array(
                        'WIDGET' => new NumberWidget(),
                        'READONLY' => true,
                        'FILTER' => false,
                        'HIDE_WHEN_CREATE' => true
                    ),
                    'DATE_CREATE' => array(
                        'WIDGET' => new DateTimeWidget(),
                        'READONLY' => true,
                        'HIDE_WHEN_CREATE' => true
                    ),
                    'CREATED_BY' => array(
                        'WIDGET' => new UserWidget(),
                        'READONLY' => true,
                        'HIDE_WHEN_CREATE' => true
                    ),
                    'TITLE' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => '80',
                        'FILTER' => '%',
                        'REQUIRED' => true,
                        'READONLY' => true,
                    ),
                    'TEXT' => array(
                        'WIDGET' => new VisualEditorWidget(),
                        'FILTER' => '%',
                        'REQUIRED' => true,
                        'READONLY' => true,
                    ),
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function helpers() {
        return array(
            '\Synch\Image\Logs\AdminInterface\LogsListHelper',
            '\Synch\Image\Logs\AdminInterface\LogsEditHelper'
        );
    }

}
