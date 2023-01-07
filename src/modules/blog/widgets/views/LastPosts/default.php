<?php declare(strict_types=1);

use app\modules\blog\models\Post;
use app\widgets\Portlet;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Post[] $posts */
?>
<?php if (count($posts)): ?>
    <?php Portlet::begin(['title' => null]); ?>
    <h4>Последние записи:</h4>

    <?php foreach ($posts as $post): ?>
        <div class="entry last">
            <?php if ($post->image): ?>
                <p class="thumb"><?= Html::img($post->getImageThumbUrl(100, 100)); ?></p>
            <?php endif; ?>

            <div class="title"><a href="<?= Url::to(['/blog/post/show', 'id' => $post->id, 'slug' => $post->slug]); ?>"><?= Html::encode($post->title); ?></a></div>
            <!--noindex-->
            <div class="short">
                <p><?= strip_tags($post->short); ?></p>
            </div><!--/noindex-->
        </div>
    <?php endforeach; ?>

    <?php Portlet::end(); ?>

<?php endif; ?>
