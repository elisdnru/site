<?php
/** @var $posts Post[] */

use app\modules\blog\models\Post;
use yii\helpers\Html;

?>
<?php if (count($posts)) : ?>
    <ul class="last_updated">
        <?php foreach ($posts as $post) : ?>
            <li><a href="<?= $post->getUrl() ?>"><?= Html::encode($post->title) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
