<?php
/** @var $tags array */

use yii\helpers\Html;

?>
<div id="tag_cloud" class="tags">
    <?php foreach ($tags as $tag) : ?>
        <?php
        $size = (int)$tag->frequency + 8;
        if ($size < 8) {
            $size = 9;
        }
        if ($size > 16) {
            $size = 16;
        }
        ?>
        <a href="<?= Html::encode($tag->url) ?>" style="font-size: <?= $size ?>pt"><?= Html::encode($tag->title) ?></a>
    <?php endforeach; ?>
</div>

