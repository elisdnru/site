<?php foreach ($news as $new): ?>

<article class="entry list">
    <header>
        <h2 class="title"><a href="<?php echo $new->url; ?>"><?php echo CHtml::encode($new->title); ?></a></h2>
        <div class="info">
            <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($new->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($new->date); ?></time></span></p>
			<?php if ($new->page): ?><p class="category"><span><a href="<?php echo $new->page->url; ?>"><?php echo CHtml::encode($new->page->title); ?></a></span></p><?php endif; ?>
        </div>
    </header>

    <div class="short"><p><?php echo trim($new->short_purified); ?></p></div>
</article>

<?php endforeach; ?>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)); ?>