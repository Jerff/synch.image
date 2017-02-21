<?php

use Bitrix\Main\Application,
    Bitrix\Main\ModuleManager,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Loader,
    Synch\Image\Logs\LogsTable;

IncludeModuleLangFile(__FILE__);

class synch_image extends CModule {

    public $MODULE_ID = 'synch.image';

    function __construct() {
        $arModuleVersion = array();

        include(__DIR__ . '/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('SYNCH_IMAGE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('SYNCH_IMAGE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('SYNCH_IMAGE_PARTNER_NAME');
        $this->PARTNER_URI = '';
    }

    public function DoInstall() {
        ModuleManager::registerModule($this->MODULE_ID);
        RegisterModuleDependences('iblock', 'OnAfterIBlockElementAdd', $this->MODULE_ID, "\Synch\Image\Event", "OnAfterIBlockElementUpdate");
        RegisterModuleDependences('iblock', 'OnAfterIBlockElementUpdate', $this->MODULE_ID, "\Synch\Image\Event", "OnAfterIBlockElementUpdate");
//        RegisterModuleDependences('iblock', 'OnBeforeIBlockElementAdd', $this->MODULE_ID, "\Synch\Image\Event", "OnBeforeIBlockElementUpdate");
        RegisterModuleDependences('iblock', 'OnBeforeIBlockElementUpdate', $this->MODULE_ID, "\Synch\Image\Event", "OnBeforeIBlockElementUpdate");
        Loader::includeModule($this->MODULE_ID);

        $this->dropTable();
        $this->GetConnection()->query("CREATE TABLE " . LogsTable::getTableName() . " (
            ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            DATE_CREATE DATETIME,
            CREATED_BY INT,
            TITLE VARCHAR(255),
            TEXT LONGTEXT,
            TEXT_TEXT_TYPE VARCHAR(255)
        );");
        $res = CAgent::GetList(Array(), ['NAME' => '\Synch\Image\Agent::upload();']);
        if ($arFields = $res->Fetch()) {
            CAgent::Delete($arFields['ID']);
        }
        CAgent::AddAgent("\Synch\Image\Agent::upload();", "synch.image", "Y", 3600, "20.02.2017 10:00:00", "Y", "", 100);
    }

    public function dropTable() {
        $this->GetConnection()->query("DROP TABLE IF EXISTS " . LogsTable::getTableName() . ";");
    }

    public function DoUninstall() {
        Loader::includeModule($this->MODULE_ID);
        $this->dropTable();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    protected function GetConnection() {
        return Application::getInstance()->getConnection(LogsTable::getConnectionName());
    }

}
