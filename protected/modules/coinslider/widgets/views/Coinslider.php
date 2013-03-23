<?php if ($files): ?>

<div id="main_slider" style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px; position:relative; overflow:hidden">
    <ul>
        <?php foreach ($files as $item) : ?>
            <?php $file = Yii::app()->file->set($item); ?>
            <li><a href="/"><img src="<?php echo $path . '/' . $file->basename; ?>" alt="" /></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<script type="text/javascript">
    jQuery(function() {
        jQuery('#main_slider').coinslider({
            width: <?php echo (int)$width; ?>,
            height: <?php echo (int)$height; ?>,
            navigation: false,
            delay: 3000
        });
    });
</script>

<?php endif; ?>