<?php
use app\components\widgets\Portlet;

/** @var $posts \app\modules\blog\models\Post[] */
?>
<?php if (count($posts)) : ?>
    <?php Portlet::begin(['title' => null]); ?>
    <h4>Последние записи:</h4>

    <?php foreach ($posts as $post) : ?>
        <div class="entry last">
            <?php if ($post->image) : ?>
                <p class="thumb"><?= CHtml::image($post->getImageThumbUrl(100, 100)) ?></p>
            <?php endif; ?>

            <div class="title"><a href="<?= $post->url ?>"><?= CHtml::encode($post->title) ?></a></div>
            <!--noindex-->
            <div class="short"><?= trim($post->short_purified) ?></div><!--/noindex-->
        </div>
    <?php endforeach; ?>

    <?php Portlet::end(); ?>

<?php endif; ?>
