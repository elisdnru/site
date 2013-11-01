<article class="entry list">
    <header>
        <?php if ($data->image): ?>
            <?php
            $properties = array();
            if ($data->image_width) $properties['width'] = $data->image_width;
            if ($data->image_height) $properties['height'] = $data->image_height;
            ?>
            <p class="thumb"><a rel="nofollow" href="<?php echo $data->url; ?>"><?php echo CHtml::image($data->getImageThumbUrl(), $data->image_alt, $properties); ?></a></p>
        <?php endif; ?>

        <h2><a href="<?php echo $data->url; ?>"><?php echo CHtml::encode($data->title); ?></a></h2>

        <div class="info">
            <?php if ($data->category): ?><p class="category"><span><a rel="nofollow" href="<?php echo $data->category->url; ?>"><?php echo CHtml::encode($data->category->title); ?></a></span></p><?php endif; ?>
        </div>
    </header>

    <div class="short"><?php echo trim($data->short_purified); ?></div>

    <div class="clear"></div>
</article>