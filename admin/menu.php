<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Synch\Image\Logs\AdminInterface\LogsListHelper;
use Synch\Image\Logs\AdminInterface\LogsEditHelper;
use Synch\Image\Replace\AdminInterface\ReplaceEditHelper;

if (!Loader::includeModule('digitalwand.admin_helper') || !Loader::includeModule('synch.image')) return;

Loc::loadMessages(__FILE__);

return array(
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 300,
        'icon' => 'fileman_sticker_icon',
        'page_icon' => 'fileman_sticker_icon',
        'text' => Loc::getMessage('SYNCH_IMAGE_Replace'),
        'url' => ReplaceEditHelper::getUrl(),
    ),
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 300,
        'icon' => 'fileman_sticker_icon',
        'page_icon' => 'fileman_sticker_icon',
        'text' => Loc::getMessage('SYNCH_IMAGE_Logs'),
        'url' => LogsListHelper::getUrl(),
        'more_url' => array(
            LogsEditHelper::getUrl(),
        )
    )
);