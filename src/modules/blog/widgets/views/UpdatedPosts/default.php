<?php if (count($posts)) : ?>
    <ul class="last_updated">
        <?php foreach ($posts as $post) : ?>
            <li><a href="<?php echo $post->url; ?>"><?php echo CHtml::encode($post->title); ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
