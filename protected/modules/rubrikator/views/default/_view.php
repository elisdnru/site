<article class="entry list">
    <header>
        <?php if ($data->image): ?>
            <?php
            $properties = array();
            if ($data->image_width) $properties['width'] = $data->image_width;
            if ($data->image_height) $properties['height'] = $data->image_height;
            ?>
            <p class="thumb"><a href="<?php echo $data->url; ?>"><?php echo CHtml::image($data->getImageThumbUrl(), $data->image_alt, $properties); ?></a></p>
        <?php endif; ?>

        <h2><a href="<?php echo $data->url; ?>"><?php echo CHtml::encode($data->title); ?></a></h2>

        <div class="info">
            <?php if ($data->category): ?><p class="category"><span><?php echo CHtml::link(CHtml::encode($data->category->title), $data->category->url); ?></span></p><?php endif; ?>
        </div>
    </header>

    <div class="short"><p><?php echo trim($data->short_purified); ?></p></div>

    <div class="clear"></div>
</article>