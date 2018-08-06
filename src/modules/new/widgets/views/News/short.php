<?php foreach ($news as $new) : ?>
    <article class="entry list">
        <header>
            <h2 class="title"><a href="<?php echo $new->url; ?>"><?php echo CHtml::encode($new->title); ?></a></h2>
            <div class="info">
                <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($new->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($new->date); ?></time></span>
                </p>
                <?php if ($new->page) :
                    ?><p class="category">
                    <span><a rel="nofollow" href="<?php echo $new->page->url; ?>"><?php echo CHtml::encode($new->page->title); ?></a></span>
                <?php endif; ?>
            </div>
        </header>

        <div class="short"><?php echo trim($new->short_purified); ?></div>
    </article>

<?php endforeach; ?>

<?php $this->widget('CLinkPager', [
    'pages' => $pages,
]); ?>
