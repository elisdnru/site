<?php $this->beginContent('//layouts/main'); ?>

<div class="main left_main">

    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_blog_top']); ?>

    <?= \app\components\widgets\BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= \app\components\widgets\MessagesWidget::widget() ?>

    <?php echo $content; ?>

    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_blog_bottom']); ?>

</div>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
