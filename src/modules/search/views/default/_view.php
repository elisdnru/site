<?php
/* @var $this DController */
/* @var $data Search */
?>

<article class="entry list">
    <header>
        <h2><a href="<?php echo $data->material->url; ?>"><?php echo SearchHighlighter::getFragment(strip_tags($data->title), $query); ?></a></h2>
        <?php if ($data->material->image): ?>
            <?php
            $properties = array();
            if (!empty($data->material->image_width)) $properties['width'] = $data->material->image_width;
            if (!empty($data->material->image_height)) $properties['height'] = $data->material->image_height;
            ?>
            <p class="thumb"><a href="<?php echo $data->material->url; ?>"><?php echo CHtml::image($data->material->getImageThumbUrl(), '', $properties); ?></a></p>
        <?php endif; ?>
    </header>
    <div class="short"><?php echo SearchHighlighter::getFragment(strip_tags($this->clearWidgets($data->text)), $query); ?>...</div>
    <div class="clear"></div>
</article>