<article class="entry grid">
    <?php if ($data->image): ?>
    <p class="thumb"><a href="<?php echo $data->url; ?>"><img src="<?php echo $data->getImageThumbUrl(250, 0); ?>" alt="" /></a></p>
    <?php endif; ?>
<div class="clear"></div>
</article>