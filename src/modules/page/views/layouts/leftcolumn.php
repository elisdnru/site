<?php $this->beginContent('//layouts/main'); ?>

<aside class="sidebar left_sidebar">

    <?php $this->renderPartial('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<div class="main right_main">

    <?= \app\components\widgets\BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= \app\components\widgets\MessagesWidget::widget() ?>

    <?php echo $content; ?>

</div>

<?php $this->endContent(); ?>
