<?php
/**
 * Created by PhpStorm.
 * User: shtrih
 * Date: 26.06.15
 * Time: 18:17
 */

class PluginContentfieldsx_ModuleTopic_EntityTopic extends PluginContentfieldsx_Inherits_ModuleTopic_EntityTopic {

    /**
     * Использовать тогда, когда важно только значение поля с уникальным именем,
     * когда не нужны прочие свойства поля, типа имени, описания.
     *
     * Вместо конструкции:
     *     {$oField = $oContentType->getFieldByName('nsfw')}
     *     {if $oField}
     *         {$oTopicField = $oTopic->getField($oField->getFieldId())}
     *         {if $oTopicField}
     *              {$oTopicField->getValue()}
     *         {/if}
     *     {/if}
     *
     * можно написать:
     *     {$oTopicField = $oTopic->getFieldValueByName('nsfw'))}
     *     {if $oTopicField}
     *         {$oTopicField->getValue()}
     *     {/if}
     *
     * @param $sFieldUniqueName string Уникальное имя поля
     * @return ModuleTopic_EntityContentValues|null
     */
    public function getFieldValueByName($sFieldUniqueName) {
        $oContentType = $this->getContentType();
        $oField = $oContentType->getFieldByName($sFieldUniqueName);
        if ($oField)
            return $this->getField($oField->getFieldId());

        return null;
    }

} 
