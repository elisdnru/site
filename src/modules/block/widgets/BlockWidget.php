<?php

namespace app\modules\block\widgets;

use app\modules\block\models\Block;
use CWidget;
use yii\caching\TagDependency;

class BlockWidget extends CWidget
{
    public $tpl = 'default';
    public $id = '';

    public function run(): void
    {
        if (!$this->id) {
            echo('<div class="flash-error">[*block|id=?*]</div>');
        }

        /** @var Block $block */
        $block = Block::find()
            ->cache(0, new TagDependency(['tags' => 'block']))
            ->andWhere(['alias' => $this->id])
            ->limit(1)
            ->one();

        if (!$block) {
            return;
        }

        echo $block->text;
    }
}
