<?php if (count($news)) : ?>
    <?php $this->beginWidget('DPortlet', ['title' => null]); ?>
    <h4>Последние записи:</h4>
    <?php foreach ($news as $new) : ?>
        <div class="entry last">
            <?php if ($new->image) : ?>
                <p class="thumb">
                    <a rel="nofollow" href="<?php echo $new->url; ?>"><?php echo CHtml::image($new->getImageThumbUrl(100, 100), $new->image_alt); ?></a>
                </p>
            <?php endif; ?>

            <h3><a href="<?php echo $new->url; ?>"><?php echo CHtml::encode($new->title); ?></a></h3>

            <div class="short"><?php echo trim($new->short_purified); ?></div>

            <div class="clear"></div>

        </div>

    <?php endforeach; ?>

    <?php $this->endWidget(); ?>

<?php endif; ?>
