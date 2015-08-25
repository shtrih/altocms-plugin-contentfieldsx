<?php

class PluginContentfieldsx_ActionAdmin extends PluginContentfieldsx_Inherits_ActionAdmin {

    protected function EventAddField() {
        $xResult = parent::EventAddField();

        if (empty($_REQUEST['submit_field'])) {
            $_REQUEST['field_unique_name'] = F::TranslitUrl(F::GetRequest('field_name'));

            if (!F::GetRequest('field_unique_name_translit'))
                $_REQUEST['field_unique_name'] = F::TranslitUrl(F::GetRequest('field_unique_name'));
        }

        return $xResult;
    }

    protected function SubmitAddField($oContentType) {

        // * Проверяем отправлена ли форма с данными
        if (!F::isPost('submit_field')) {
            return false;
        }

        // * Проверка корректности полей формы
        if (!$this->CheckFieldsField($oContentType)) {
            return false;
        }

        $oField = E::GetEntity('Topic_Field');
        $oField->setFieldType(F::GetRequest('field_type'));
        $oField->setContentId($oContentType->getContentId());
        $oField->setFieldName(F::GetRequest('field_name'));
        $oField->setFieldDescription(F::GetRequest('field_description'));
        $oField->setFieldRequired(F::GetRequest('field_required'));
        if (F::GetRequest('field_type') == 'select') {
            $oField->setOptionValue('select', F::GetRequest('field_values'));
        }

        $sFieldUniqueName = F::TranslitUrl(F::GetRequest('field_unique_name'));
        if (F::GetRequest('field_unique_name_translit'))
            $sFieldUniqueName = F::TranslitUrl(F::GetRequest('field_name'));

        $oField->setFieldUniqueName($sFieldUniqueName);

        try {
            if (E::ModuleTopic()->AddContentField($oField)) {
                E::ModuleMessage()->AddNoticeSingle(E::ModuleLang()->Get('action.admin.contenttypes_success_fieldadd'), null, true);
                R::Location('admin/settings-contenttypes/edit/' . $oContentType->getContentId() . '/');
            }
        }
        catch (Exception $e) {
            // Если ошибка дублирования уникального ключа, то выводим соответствующее сообщение
            if (1062 == $e->getCode()) {
                E::ModuleMessage()->AddErrorSingle(
                    E::ModuleLang()->Get('plugin.contentfieldsx.error_field_unique_name_duplicate', array('unique_name' => htmlspecialchars($sFieldUniqueName))),
                    null,
                    false
                );
            }
        }

        return false;
    }

    protected function EventEditField() {
        $xResult = parent::EventEditField();

        if (empty($_REQUEST['submit_field'])) {
            $oField = E::ModuleViewer()->getTemplateVars('oField');
            $_REQUEST['field_unique_name'] = $oField->getFieldUniqueName();
        }

        return $xResult;
    }

    /**
     * Редактирование поля контента
     *
     * @param ModuleTopic_EntityContentType $oContentType
     * @param ModuleTopic_EntityField $oField
     * @return bool
     */
    protected function SubmitEditField($oContentType, $oField) {

        // * Проверяем отправлена ли форма с данными
        if (!F::isPost('submit_field')) {
            return false;
        }

        // * Проверка корректности полей формы
        if (!$this->CheckFieldsField($oContentType)) {
            return false;
        }

        if (!E::ModuleTopic()->GetFieldValuesCount($oField->getFieldId())) {
            // Нет ещё ни одного значения этого поля, тогда можно сменить ещё и тип
            $oField->setFieldType(F::GetRequest('field_type'));
        }
        $oField->setFieldName(F::GetRequest('field_name'));
        $oField->setFieldDescription(F::GetRequest('field_description'));
        $oField->setFieldRequired(F::GetRequest('field_required'));
        if ($oField->getFieldType() == 'select') {
            $oField->setOptionValue('select', F::GetRequest('field_values'));
        }

        $sOldFieldUniqueName = $oField->getFieldUniqueName();
        if (F::GetRequest('field_unique_name_translit'))
            $oField->setFieldUniqueName(F::TranslitUrl(F::GetRequest('field_name')));
        else
            $oField->setFieldUniqueName(F::TranslitUrl(F::GetRequest('field_unique_name')));

        try {
            if (E::ModuleTopic()->UpdateContentField($oField)) {
                E::ModuleMessage()->AddNoticeSingle(E::ModuleLang()->Get('action.admin.contenttypes_success_fieldedit'), null, true);
                R::Location('admin/settings-contenttypes/edit/' . $oContentType->getContentId() . '/');
            }
        }
        catch (Exception $e) {
            // Если ошибка дублирования уникального ключа, то выводим соответствующее сообщение
            if (1062 == $e->getCode()) {
                $sNewFieldUniqueName = $oField->getFieldUniqueName();
                $oField->setFieldUniqueName($sOldFieldUniqueName);
                E::ModuleMessage()->AddErrorSingle(
                    E::ModuleLang()->Get('plugin.contentfieldsx.error_field_unique_name_duplicate', array('unique_name' => htmlspecialchars($sNewFieldUniqueName))),
                    null,
                    false
                );

            }
        }

        return false;
    }
}


