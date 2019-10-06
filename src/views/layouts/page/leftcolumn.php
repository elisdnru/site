<?php $this->beginContent('//layouts/main'); ?>

<aside class="sidebar left_sidebar">

    <?php $this->renderPartial('//layouts/page/sidebars/default'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<div class="main right_main">

    <?php $this->widget(\app\components\widgets\BreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\components\widgets\MessagesWidget::class); ?>

    <?php echo $content; ?>

</div>

<?php $this->endContent(); ?>
