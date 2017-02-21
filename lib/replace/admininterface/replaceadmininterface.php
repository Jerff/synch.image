<?php

namespace Synch\Image\Replace\AdminInterface;

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
class ReplaceAdminInterface extends AdminInterface {

    /**
     * {@inheritdoc}
     */
    public function fields() {
        return array(
            'MAIN' => array(
                'NAME' => Loc::getMessage('SYNCH_IMAGE_Replace'),
                'FIELDS' => array(
                    'CREATED_BY' => array(
                        'WIDGET' => new FileWidget(),
                        'IMAGE' => false,
                        'HEADER' => false
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
            '\Synch\Image\Replace\AdminInterface\ReplaceListHelper',
            '\Synch\Image\Replace\AdminInterface\ReplaceEditHelper'
        );
    }

}
