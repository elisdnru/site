<?php foreach ($news as $data): ?>

<article class="entry list">
    <header>

        <h2><a href="<?php echo $data->url; ?>"><?php echo CHtml::encode($data->title); ?></a></h2>
        <div class="info">
            <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($data->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($data->date); ?></time></span></p>
            <?php if ($data->page): ?>
                <p class="category"><span><a rel="nofollow" href="<?php echo $data->page->url; ?>"><?php echo CHtml::encode($data->page->title); ?></a></span></p>
            <?php endif; ?>
            <?php if (Yii::app()->moduleManager->active('comment')) : ?>
            <p class="comments"><span><a rel="nofollow" href="<?php echo $data->url; ?>#comments"><?php echo $data->comments_count; ?></a></span></p>
            <?php endif; ?>
        </div>
        <?php if ($data->image): ?>
            <?php
            $properties = array();
            if ($data->image_width) $properties['width'] = $data->image_width;
            if ($data->image_height) $properties['height'] = $data->image_height;
            ?>
            <p class="thumb"><a rel="nofollow" href="<?php echo $data->url; ?>"><?php echo CHtml::image($data->getImageThumbUrl(), $data->image_alt, $properties); ?></a></p>
        <?php endif; ?>

    </header>

    <div class="short"><?php echo trim($data->short_purified); ?></div>

    <p class="more"><a rel="nofollow" href="<?php echo $data->url; ?>">Читать далее</a></p>

    <div class="clear"></div>
</article>

<?php endforeach; ?>