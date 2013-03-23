<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

Yii::import('zii.widgets.grid.CButtonColumn');

class DButtonColumn extends CButtonColumn
{
    public function init()
    {
        $this->updateButtonImageUrl = Yii::app()->request->baseUrl . '/core/images/admin/edit.png';
        $this->deleteButtonImageUrl = Yii::app()->request->baseUrl . '/core/images/admin/del.png';
        $this->viewButtonImageUrl = Yii::app()->request->baseUrl . '/core/images/admin/view.png';

        parent::init();
    }
}
