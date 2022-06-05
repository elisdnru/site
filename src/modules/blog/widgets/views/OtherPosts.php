<?php declare(strict_types=1);

use app\components\purifier\PurifierWidget;
use app\modules\blog\models\Post;
use yii\helpers\Html;

/** @var Post[] $posts */
?>
<?php if (count($posts)) : ?>
    <div class="block-title">Другие статьи</div>
    <div style="margin: 20px 0">

        <?php foreach ($posts as $post) : ?>
            <div class="entry last">
                <?php if ($post->image) : ?>
                    <p class="thumb">
                        <a href="<?= $post->getUrl(); ?>"><?= Html::img($post->getImageThumbUrl(100, 100)); ?></a>
                    </p><!--/noindex-->
                <?php endif; ?>
                <div class="title"><a href="<?= $post->getUrl(); ?>"><?= Html::encode($post->title); ?></a>
                </div>
                <!--noindex-->
                <div class="short">
                    <?php PurifierWidget::begin(); ?>
                    <?= $post->short; ?>
                    <?php PurifierWidget::end(); ?>
                </div><!--/noindex-->
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
