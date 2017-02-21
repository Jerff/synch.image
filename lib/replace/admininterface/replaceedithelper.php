<?php

namespace Synch\Image\Replace\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper,
    Synch\Image\Replace,
    Synch\Image\Settings;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class ReplaceEditHelper extends AdminEditHelper {

    protected static $model = '\Synch\Image\Replace\ReplaceTable';

    protected function showEpilog() {
        echo implode('<br>', Replace\Logs::get());
        parent::showEpilog();
    }

    protected function editAction() {
        $this->setContext(AdminEditHelper::OP_EDIT_ACTION_BEFORE);

        if (!$this->hasWriteRights()) {
            $this->addErrors(Loc::getMessage('DIGITALWAND_ADMIN_HELPER_EDIT_WRITE_FORBIDDEN'));

            return false;
        }

        $allWidgets = array();

        foreach ($this->getFields() as $code => $settings) {
            if ($settings['READONLY'] && $code !== $this->pk()) {
                unset($this->data[$code]);
            }
        }

        foreach ($this->getFields() as $code => $settings) {
            $widget = $this->createWidgetForField($code, $this->data);
            $widget->processEditAction();
            $this->validationErrors = array_merge($this->validationErrors, $widget->getValidationErrors());
            $allWidgets[] = $widget;

            if ($widget->getSettings('READONLY') || empty($this->data[$this->pk()]) && $widget->getSettings('HIDE_WHEN_CREATE')) {
                unset($this->data[$code]);
            }
        }

        $this->addErrors($this->validationErrors);
        $success = empty($this->validationErrors);

        if ($success) {
            if (empty($_FILES['FIELDS']['error']['CREATED_BY'])) {
                Settings::setModeReplace();
                $articulList = array_map('trim', file($_FILES['FIELDS']['tmp_name']['CREATED_BY_FILE']));
                Replace::findImage($articulList);
            }
            foreach ($allWidgets as $widget) {
                $widget->processAfterSaveAction();
            }
        }
        return true;
    }

    protected function getMenu($showDeleteButton = true) {
        return array();
    }

    protected function setElementTitle() {
        $this->setTitle('Замена фотографий');
    }

    protected function saveElement($id = null) {
        return array();
    }

    protected function show404() {

    }

}
