<?php foreach ($recipes as $recipe): ?>

<article class="entry list">
    <header>
        <?php if ($recipe->image): ?>
        <p class="thumb"><a href="<?php echo $recipe->url; ?>"><img src="<?php echo $recipe->getImageThumbUrl(250, 0); ?>" alt="<?php echo $recipe->image_alt; ?>" /></a></p>
        <?php endif; ?>

        <h2><a href="<?php echo $recipe->url; ?>"><?php echo CHtml::encode($recipe->title); ?></a></h2>
        <div class="info">
            <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($recipe->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($recipe->date); ?></time></span></p>
        </div>
    </header>

    <div class="short"><p><?php echo trim($recipe->short_purified); ?></p></div>

    <div class="clear"></div>
</article>

<?php endforeach; ?>