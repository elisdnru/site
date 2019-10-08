<div id="tag_cloud" class="tags">
    <?php foreach ($tags as $tag): ?>
        <?php
            $size = (int)$tag->frequency + 8;
            if ($size < 8) {
                $size = 9;
            }
            if ($size > 16) {
                $size = 16;
            }
        ?>
        <a href="<?= CHtml::encode($tag->url) ?>" style="font-size: <?= $size ?>pt"><?= CHtml::encode($tag->title) ?></a>
    <?php endforeach; ?>
</div>

