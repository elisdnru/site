<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DPingBehavior extends CActiveRecordBehavior
{
    public $urlAttribute = 'url';

    public function afterSave($event)
    {
        $model = $this->getOwner();
        if ($model->isNewRecord)
            Yii::app()->rpcManager->pingPage($model->{$this->urlAttribute});
    }
}