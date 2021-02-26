<?php

use app\modules\blog\models\Post;
use yii\helpers\Html;

/** @var Post[] $posts */

?>
<?php if (count($posts)) : ?>
    <ul class="last-updated">
        <?php foreach ($posts as $post) : ?>
            <li><a href="<?= $post->getUrl() ?>"><?= Html::encode($post->title) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
