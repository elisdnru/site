<?php

declare(strict_types=1);

namespace app\modules\block\widgets;

use app\modules\block\models\Block;
use yii\base\Widget;
use yii\caching\TagDependency;

class BlockWidget extends Widget
{
    public string $title = 'default';
    public string $tpl = 'default';
    public string $id = '';

    public function run(): string
    {
        if (!$this->id) {
            return '<div class="flash-error">[*block|id=?*]</div>';
        }

        /** @var Block|null $block */
        $block = Block::find()
            ->cache(0, new TagDependency(['tags' => 'block']))
            ->andWhere(['alias' => $this->id])
            ->limit(1)
            ->one();

        if ($block === null) {
            return '';
        }

        return $block->text;
    }
}
