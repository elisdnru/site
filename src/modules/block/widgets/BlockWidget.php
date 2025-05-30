<?php

declare(strict_types=1);

namespace app\modules\block\widgets;

use app\modules\block\models\Block;
use Override;
use yii\base\Widget;
use yii\caching\TagDependency;

final class BlockWidget extends Widget
{
    public string $id = '';

    #[Override]
    public function run(): string
    {
        if (!$this->id) {
            return '<div class="flash-error">[*block|id=?*]</div>';
        }

        $block = Block::find()
            ->cache(0, new TagDependency(['tags' => 'block']))
            ->andWhere(['slug' => $this->id])
            ->limit(1)
            ->one();

        if ($block === null) {
            return '';
        }

        return $block->text;
    }
}
