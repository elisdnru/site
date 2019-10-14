<?php $this->beginContent('//layouts/main'); ?>

<div class="main left_main">

    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_blog_top']); ?>

    <?php $this->widget(\app\components\widgets\BreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\components\widgets\MessagesWidget::class); ?>

    <?php echo $content; ?>

    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_blog_bottom']); ?>

</div>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
