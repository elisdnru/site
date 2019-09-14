<?php $this->beginContent('//layouts/main'); ?>

<section class="main left_main">

    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_blog_top']); ?>

    <?php $this->widget(\app\modules\main\widgets\DBreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\modules\main\widgets\DMessagesWidget::class); ?>

    <?php echo $content; ?>

    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_blog_bottom']); ?>

</section>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/sidebars/blog'); ?>

</aside>

<?php $this->endContent(); ?>
