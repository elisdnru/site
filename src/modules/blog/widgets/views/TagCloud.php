<?php declare(strict_types=1);

use app\modules\blog\models\Tag;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Tag[] $tags
 */
?>
<div class="tags">
    <?php foreach ($tags as $tag) : ?>
        <?php
        $size = $tag->getFrequency() + 8;
        if ($size < 8) {
            $size = 9;
        }
        if ($size > 16) {
            $size = 16;
        }
        ?>
        <a href="<?= Url::to(['/blog/default/tag', 'tag' => $tag->title]); ?>" style="font-size: <?= $size; ?>pt"><?= Html::encode($tag->title); ?></a>
    <?php endforeach; ?>
</div>

