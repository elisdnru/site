<?php $this->beginContent('//layouts/main'); ?>

<section class="main">

    <?= \app\components\widgets\BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= \app\components\widgets\MessagesWidget::widget() ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>
