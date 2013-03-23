<?php $limit = 200; ?>

<?php foreach ($reviews as $review): ?>

<article class="entry list">
    <h2><a href="<?php echo $review->url; ?>"><?php echo CHtml::encode($review->name); ?></a></h2>

    <div class="short"><p><?php echo nl2br(mb_substr(strip_tags($review->text_purified), 0, $limit, 'UTF-8')); ?><?php if (mb_strlen($review->text_purified, 'UTF-8') > $limit): ?>...<br /><a rel="nofollow" href="<?php echo $review->url; ?>">Далее &rarr;</a><?php endif; ?>
    </p></div>

    <div class="clear"></div>
</article>

<?php endforeach; ?>