<?php declare(strict_types=1);

use app\components\purifier\PurifierWidget;
use app\modules\blog\models\Post;
use app\widgets\Portlet;
use yii\helpers\Html;

/** @var Post[] $posts */
?>
<?php if (count($posts)) : ?>
    <?php Portlet::begin(['title' => null]); ?>
    <h4>Последние записи:</h4>

    <?php foreach ($posts as $post) : ?>
        <div class="entry last">
            <?php if ($post->image) : ?>
                <p class="thumb"><?= Html::img($post->getImageThumbUrl(100, 100)); ?></p>
            <?php endif; ?>

            <div class="title"><a href="<?= $post->getUrl(); ?>"><?= Html::encode($post->title); ?></a></div>
            <!--noindex-->
            <div class="short">
                <?php PurifierWidget::begin(); ?>
                <?= $post->short; ?>
                <?php PurifierWidget::end(); ?>
            </div><!--/noindex-->
        </div>
    <?php endforeach; ?>

    <?php Portlet::end(); ?>

<?php endif; ?>
