<?php $this->beginContent('//layouts/main'); ?>

<section class="main">

    <?php $this->widget(\app\modules\main\widgets\BreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\modules\main\widgets\MessagesWidget::class); ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>
