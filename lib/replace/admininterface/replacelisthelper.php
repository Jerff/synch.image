<?php

namespace Synch\Image\Replace\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper,
    Synch\Image\Replace\AdminInterface\ReplaceEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class ReplaceListHelper extends AdminListHelper {

    protected static $model = '\Synch\Image\Replace\ReplaceTable';

    public function __construct(array $fields, $isPopup = false) {
        LocalRedirect(ReplaceEditHelper::getUrl());
    }

}
