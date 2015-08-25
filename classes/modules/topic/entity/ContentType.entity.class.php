<?php
/**
 * Created by PhpStorm.
 * User: shtrih
 * Date: 26.06.15
 * Time: 19:08
 */

class PluginContentfieldsx_ModuleTopic_EntityContentType extends PluginContentfieldsx_Inherits_ModuleTopic_EntityContentType {

    /**
     * @param $sFieldUniqueName string Уникальное имя поля
     * @return ModuleTopic_EntityField|null
     */
    public function getFieldByName($sFieldUniqueName) {
        $aFields = E::ModuleTopic()->GetContentFields(array('content_id' => $this->getContentId(), 'field_unique_name' => $sFieldUniqueName));

        return sizeof($aFields) ? array_pop($aFields) : null;
    }
}
