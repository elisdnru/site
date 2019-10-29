<?php
/** @var $posts \app\modules\blog\models\Post[] */

use yii\helpers\Html;

?>
<?php if (count($posts)) : ?>
    <div class="block-title">Другие статьи</div>
    <div style="margin: 20px 0">

        <?php foreach ($posts as $post) : ?>
            <div class="entry last">
                <?php if ($post->image) : ?>
                    <p class="thumb">
                        <a href="<?= $post->url ?>"><?= CHtml::image($post->getImageThumbUrl(100, 100)) ?></a>
                    </p><!--/noindex-->
                <?php endif; ?>
                <div class="title"><a href="<?= $post->url ?>"><?= Html::encode($post->title) ?></a>
                </div>
                <!--noindex-->
                <div class="short"><?= trim($post->short_purified) ?></div><!--/noindex-->
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
