# Content Fields eXtended
ContentFieldsX это плагин для [Alto CMS](https://github.com/altocms/altocms), который предназначен для облегчения работы с дополнительными полями типов контента.
Чтобы понять, как работать с дополнительными полями, читайте пост http://altocms.ru/1182.html

В форме создания дополнительного поля, появляется «Уникальное имя поля», которое заполняется по усмотрению админа, чтобы затем,
в шаблонах (обычно это `topic.type_ваш-тип-show.tpl` и `topic.type_ваш-тип-list.tpl`) по имени получать значение поля, не привязываясь к динамическим идентификаторам полей.

По сути, добавляет два новых метода `$oTopic->getFieldValueByName()` и `$oContentType->getFieldByName($sFieldName)`.
`getFieldByName` является альтернативой `$oContentType->getField($iFieldId)`.
А `getFieldValueByName` пригодится тогда, когда нам не нужна информация о поле (имя поля, описание).
Вместо конструкции:
```smarty
{$oField = $oContentType->getFieldByName('nsfw')}
{if $oField}
    {$oTopicField = $oTopic->getField($oField->getFieldId())}
    {if $oTopicField}
         {$oTopicField->getValue()}
    {/if}
{/if}
```
можно написать:
```smarty
{$oTopicField = $oTopic->getFieldValueByName('nsfw'))}
{if $oTopicField}
    {$oTopicField->getValue()}
{/if}
```

## Примеры использования
### Получить значение поля по уникальному имени
В переменную `$oNsfw` запишется экземпляр класса `ModuleTopic_EntityContentValues` или `null`:
```smarty
{$oNsfw = $oTopic->getFieldValueByName('nsfw')}
```

### Получение экземпляра поля `ModuleTopic_EntityField`
В переменную `$oFieldNsfw` запишется экземпляр класса `ModuleTopic_EntityField` или `null`:
```smarty
{$oContentType = $oTopic->getContentType()}
{$oFieldNsfw = $oContentType->getFieldByName('nsfw')}

{* Печатаем значение c помощью стандартного шаблона для отображения поля *}
{include file="fields/customs/field.custom.`$oFieldNsfw->getFieldType()`-show.tpl" oField=$oFieldNsfw}
```

### Пропуск полей
После того, как мы запросили и использовали нужные нам поля с уникальными именами, нужно не дать им вывестись со всеми остальными полями.
В данном случае, пропускаются поля `nsfw` и `nsfw-pictures`:
```smarty
{* topic.type_mycontenttype-show.tpl *}

{foreach from=$oContentType->getFields() item=oField}
    {* Пропускаем некоторые поля *}
    {if in_array($oField->getFieldUniqueName(), ['nsfw', 'nsfw-pictures'])}
        {continue}
    {/if}

    {include file="fields/customs/field.custom.`$oField->getFieldType()`-show.tpl" oField=$oField}
{/foreach}
```

## Использование совместно с другими плагинами
В манифесте вашего плагина (`plugin.xml`) в секцию `requires/plugins` добавьте `plugin` как показано ниже:
```xml
    …
    <requires>
        …
        <plugins>
            <plugin name="ContentFieldsX" version="1.0.0" condition="gte">contentfieldsx</plugin>
        </plugins>
    </requires>
    …
```

# Лизцензия
Плагин распространяется под лицензией MIT, подробнее в файле LICENSE.txt
