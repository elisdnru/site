<?php

namespace app\modules\block\widgets;

use app\modules\block\models\Block;
use app\modules\main\components\widgets\DWidget;
use app\extensions\cachetagging\Tags;

class BlockWidget extends DWidget
{
    public $tpl = 'default';
    public $id = '';

    public function run()
    {
        if (!$this->id) {
            echo('<div class="flash-error">[*block|id=?*]</div>');
        }

        $model = Block::model()->cache(0, new Tags('block'))->find('alias=:alias', ['alias' => $this->id]);
        if (!$model) {
            return false;
        }

        echo $model->text;
    }
}
