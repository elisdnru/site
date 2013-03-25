<?php
$per_line = 4;
$i=0;
?>

<div class="greed_container">
<?php foreach ($news as $new):  ?>

<article class="entry greed">

    <?php if ($new->image): ?>
    <p class="thumb"><a href="<?php echo $new->url; ?>"><span style="background-image: url('<?php echo $new->imageThumbUrl; ?>')"></span></a></p>
    <?php endif; ?>

    <h2 class="title"><a href="<?php echo $new->url; ?>"><?php echo CHtml::encode($new->title); ?></a></h2>
    <?php if (trim($new->short)): ?><div class="short"><p><?php echo trim($new->short_purified); ?></p></div><?php endif; ?>

</article>

<?php if ($per_line && ($i+1) % $per_line == 0) : ?><div class="clear"></div><?php endif; ?>

<?php $i++; endforeach; ?>
    <div class="clear"></div>
</div>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)); ?>
