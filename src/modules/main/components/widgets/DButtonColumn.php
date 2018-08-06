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
        if ($this->updateButtonImageUrl === null) {
            $this->updateButtonImageUrl = Yii::app()->request->baseUrl . '/images/admin/edit.png';
        }
        if ($this->deleteButtonImageUrl === null) {
            $this->deleteButtonImageUrl = Yii::app()->request->baseUrl . '/images/admin/del.png';
        }
        if ($this->viewButtonImageUrl === null) {
            $this->viewButtonImageUrl = Yii::app()->request->baseUrl . '/images/admin/view.png';
        }

        parent::init();
    }
}
