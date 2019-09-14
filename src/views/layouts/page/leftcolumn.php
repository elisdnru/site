<?php $this->beginContent('//layouts/main'); ?>

<aside class="sidebar left_sidebar">

    <?php $this->renderPartial('//layouts/page/sidebars/default'); ?>

</aside>

<section class="main right_main">

    <?php $this->widget(\DBreadcrumbsWidget::class); ?>
    <?php $this->widget(\DMessagesWidget::class); ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>
