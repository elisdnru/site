<?php

namespace app\modules\block\widgets;

use app\modules\block\models\Block;
use app\components\widgets\Widget;
use app\extensions\cachetagging\Tags;

class BlockWidget extends Widget
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
            return;
        }

        echo $model->text;
    }
}
