<?php
/** @var $posts \app\modules\blog\models\Post[] */
?>
<?php if (count($posts)) : ?>
    <ul class="last_updated">
        <?php foreach ($posts as $post) : ?>
            <li><a href="<?= $post->url ?>"><?= CHtml::encode($post->title) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
