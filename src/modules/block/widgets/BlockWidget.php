<?php

namespace app\modules\block\widgets;

use app\modules\block\models\Block;
use app\components\widgets\Widget;
use app\extensions\cachetagging\Tags;
use yii\caching\TagDependency;

class BlockWidget extends Widget
{
    public $tpl = 'default';
    public $id = '';

    public function run(): void
    {
        if (!$this->id) {
            echo('<div class="flash-error">[*block|id=?*]</div>');
        }

        $model = Block::find()->cache(0, new TagDependency(['tags' => 'block']))->andWhere(['alias' => $this->id])->limit(1)->one();
        if (!$model) {
            return;
        }

        echo $model->text;
    }
}
