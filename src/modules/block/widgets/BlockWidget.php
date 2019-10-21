<?php

namespace app\modules\block\widgets;

use app\modules\block\models\Block;
use yii\base\Widget;
use yii\caching\TagDependency;

class BlockWidget extends Widget
{
    public $title = 'default';
    public $tpl = 'default';
    public $id = '';

    public function run(): string
    {
        if (!$this->id) {
            return '<div class="flash-error">[*block|id=?*]</div>';
        }

        /** @var Block $block */
        $block = Block::find()
            ->cache(0, new TagDependency(['tags' => 'block']))
            ->andWhere(['alias' => $this->id])
            ->limit(1)
            ->one();

        if (!$block) {
            return '';
        }

        return $block->text;
    }
}
