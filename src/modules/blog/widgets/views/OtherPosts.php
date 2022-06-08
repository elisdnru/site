<?php declare(strict_types=1);

use app\modules\blog\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Post[] $posts */
?>
<?php if (count($posts)) : ?>
    <div class="block-title">Другие статьи</div>
    <div style="margin: 20px 0">

        <?php foreach ($posts as $post) : ?>
            <?php $url = Url::to(['/blog/post/show', 'id' => $post->id, 'slug' => $post->slug]); ?>
            <div class="entry last">
                <?php if ($post->image) : ?>
                    <p class="thumb">
                        <a href="<?= $url; ?>"><?= Html::img($post->getImageThumbUrl(100, 100)); ?></a>
                    </p><!--/noindex-->
                <?php endif; ?>
                <div class="title"><a href="<?= $url; ?>"><?= Html::encode($post->title); ?></a>
                </div>
                <!--noindex-->
                <div class="short">
                    <p><?= strip_tags($post->short); ?></p>
                </div><!--/noindex-->
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
