<?php $this->beginContent('//layouts/main'); ?>

<section class="main left_main">

    <?php $this->widget(\BlockWidget::class, ['id' => 'banner_blog_top']); ?>

    <?php $this->widget(\DBreadcrumbsWidget::class); ?>
    <?php $this->widget(\DMessagesWidget::class); ?>

    <?php echo $content; ?>

    <?php $this->widget(\BlockWidget::class, ['id' => 'banner_blog_bottom']); ?>

</section>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/sidebars/blog'); ?>

</aside>

<?php $this->endContent(); ?>
