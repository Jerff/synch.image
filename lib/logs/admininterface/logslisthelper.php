<?php

namespace Synch\Image\Logs\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class LogsListHelper extends AdminListHelper
{
	protected static $model = '\Synch\Image\Logs\LogsTable';
}