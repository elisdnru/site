<?php foreach ($news as $new): ?>

<article class="entry list">
    <header>
        <h2 class="title"><a href="<?php echo $new->url; ?>"><?php echo CHtml::encode($new->title); ?></a></h2>
        <?php if ($new->image): ?>
        <p class="thumb"><a rel="nofollow" href="<?php echo $new->url; ?>"><?php echo CHtml::image($new->imageThumbUrl, $new->image_alt); ?></a></p>
        <?php endif; ?>
        <div class="info">
            <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($new->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($new->date); ?></time></span></p>
            <?php if ($new->page): ?><p class="category"><span><a rel="nofollow" href="<?php echo $new->page->url; ?>"><?php echo CHtml::encode($new->page->title); ?></a></span></p><?php endif; ?>
        </div>
    </header>

    <div class="short"><?php echo trim($new->short_purified); ?></div>

    <aside>
        <p class="more"><a rel="nofollow" href="<?php echo $new->url; ?>">Подробнее</a></p>
    </aside>

    <div class="clear"></div>
    <footer>
        <?php if (Yii::app()->moduleManager->active('comment')) : ?><p class="comments">Комментариев: <?php echo $new->comments_count; ?><p><?php endif; ?>
        <p>&nbsp;</p>
    </footer>
    <div class="clear"></div>
</article>

<?php endforeach; ?>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)); ?>