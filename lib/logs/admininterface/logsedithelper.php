<?php

namespace Synch\Image\Logs\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class LogsEditHelper extends AdminEditHelper
{
    protected static $model = '\Synch\Image\Logs\LogsTable';
}