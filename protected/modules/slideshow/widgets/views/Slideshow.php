<?php if (count($items)): ?>

<?php
$id = uniqid('slider_');
?>

<div id="<?php echo $id; ?>" class="slider">
    <ul>
        <?php foreach ($items as $item) : ?>

        <li style="background-image: url('<?php echo $item['image']; ?>');">
            <a class="bg_link" rel="nofollow" href="<?php echo CHtml::encode($item['url']); ?>"></a>
            <div class="content">
                <p class="title"><span><a href="<?php echo CHtml::encode($item['url']); ?>"><?php echo nl2br(CHtml::encode($item['title'])) ; ?></a></span></p>
                <?php if ($item['text']): ?> <p class="text"><span><?php echo nl2br(CHtml::encode($item['text'])) ; ?></span></p><?php endif; ?>
            </div>
        </li>

        <?php endforeach; ?>
    </ul>
</div>

<script type="text/javascript">
    jQuery(function() {
        jQuery('#<?php echo $id; ?>').easySlider(<?php echo CJSON::encode($options); ?>);
    });
</script>

<?php endif; ?>