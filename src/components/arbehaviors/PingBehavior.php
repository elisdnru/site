<?php

namespace app\components\arbehaviors;

use CActiveRecordBehavior;
use Yii;

class PingBehavior extends CActiveRecordBehavior
{
    public $urlAttribute = 'url';

    public function afterSave($event)
    {
        $model = $this->getOwner();
        if ($model->isNewRecord) {
            Yii::app()->rpcManager->pingPage($model->{$this->urlAttribute});
        }
    }
}
