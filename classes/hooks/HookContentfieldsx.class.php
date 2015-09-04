<?php

class PluginContentfieldsx_HookContentfieldsx extends Hook {

    public function RegisterHook() {
        $this->AddHook('template_admin_content_add_field_properties', 'renderProperties');
    }

    public function renderProperties() {
        return E::ModuleViewer()->Fetch(Plugin::GetTemplateFile(__CLASS__, 'tpls/hooks/hook.admin_content_add_field_properties.tpl'));
    }
}

