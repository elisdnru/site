<?php $this->beginContent('//layouts/main'); ?>

<div class="main left_main">

    <?php $this->widget(\app\modules\main\widgets\DBreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\modules\main\widgets\DMessagesWidget::class); ?>

    <?php echo $content; ?>

</div>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/sidebars/portfolio'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
