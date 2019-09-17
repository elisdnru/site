<?php

namespace app\modules\main\components\widgets;

use CButtonColumn;
use Yii;

Yii::import('zii.widgets.grid.CButtonColumn');

class ButtonColumn extends CButtonColumn
{
    public function init()
    {
        if ($this->updateButtonImageUrl === null) {
            $this->updateButtonImageUrl = '/images/admin/edit.png';
        }
        if ($this->deleteButtonImageUrl === null) {
            $this->deleteButtonImageUrl = '/images/admin/del.png';
        }
        if ($this->viewButtonImageUrl === null) {
            $this->viewButtonImageUrl = '/images/admin/view.png';
        }

        parent::init();
    }
}
