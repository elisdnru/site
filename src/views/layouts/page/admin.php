<?php $this->beginContent('//layouts/main'); ?>

<section class="main" id="admin">

    <?php $this->widget(\app\modules\main\widgets\DBreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\modules\main\widgets\DMessagesWidget::class); ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>
