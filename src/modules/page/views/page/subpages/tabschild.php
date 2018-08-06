<!-- Подстраницы (дочерние табы) -->
<?php if ($this->beginCache(__FILE__ . __LINE__ . '_tabschild_' . $page->id, ['dependency' => new Tags('page')])) : ?>
    <?php if ($page->child_pages) : ?>
        <?php if (!$page->hidetitle) : ?>
            <h1><?php echo $page->title; ?></h1>
        <?php endif; ?>

        <div class="subpages">
            <ul>
                <?php foreach ($page->child_pages as $child) : ?>
                    <li><a href="<?php echo $child->url; ?>"><?php echo $child->title; ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>

    <?php else : ?>
        <?php if (!$page->hidetitle) : ?>
            <h1><?php echo $page->title; ?></h1>
        <?php endif; ?>

    <?php endif; ?>

    <?php $this->endCache(); ?>
<?php endif; ?>
<!-- /Подстраницы (дочерние табы) -->
