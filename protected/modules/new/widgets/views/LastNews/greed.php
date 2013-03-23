<?php
$per_line = 4;
$i=0;
?>

<div class="greed_container">
<?php foreach ($news as $new):  ?>

    <article class="entry greed">

        <p class="thumb"><a href="<?php echo $new->url; ?>" style="background-image: url('<?php echo $new->getImageThumbUrl(198, 180); ?>')"><span><?php echo CHtml::encode($new->title); ?></span></a></p>

    </article>

<?php if ($per_line && ($i+1) % $per_line == 0) : ?><div class="clear"></div><?php endif; ?>

<?php $i++; endforeach; ?>
    <div class="clear"></div>
</div>