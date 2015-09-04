<div class="control-group">
    <label for="field_unique_name" class="control-label">
        {$aLang.plugin.contentfieldsx.contenttypes_unique_name}
    </label>

    <div class="controls">
        <input id="field_unique_name" type="text" name="field_unique_name" value="{$_aRequest.field_unique_name}" class="input-text">
        <span class="help-block">{$aLang.plugin.contentfieldsx.contenttypes_unique_name_help}</span>
    </div>

    <div class="controls">
        <label><input type="checkbox" name="field_unique_name_translit" />Транслит из поля «{$aLang.action.admin.contenttypes_name}» (чтобы не вводить вручную)</label>
    </div>
</div>
