<ul class="<?php echo $class; ?>">
    <?php foreach ($news as $new) : ?>
        <li><a href="<?php echo $new->url; ?>"><?php echo CHtml::encode($new->title); ?></a></li>
    <?php endforeach; ?>
</ul>
