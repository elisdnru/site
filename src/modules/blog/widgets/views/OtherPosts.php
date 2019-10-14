<?php
/** @var $posts \app\modules\blog\models\Post[] */
?>
<?php if (count($posts)) : ?>
    <div class="block-title">Другие статьи</div>
    <div style="margin: 20px 0">

        <?php foreach ($posts as $post) : ?>
            <div class="entry last">
                <?php if ($post->image) : ?>
                    <p class="thumb">
                        <a href="<?php echo $post->url; ?>"><?php echo CHtml::image($post->getImageThumbUrl(100, 100)); ?></a>
                    </p><!--/noindex-->
                <?php endif; ?>
                <div class="title"><a href="<?php echo $post->url; ?>"><?php echo CHtml::encode($post->title); ?></a>
                </div>
                <!--noindex-->
                <div class="short"><?php echo trim($post->short_purified); ?></div><!--/noindex-->
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
