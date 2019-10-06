<?php $this->beginContent('//layouts/main'); ?>
<section class="main">

    <?php $this->widget(\app\components\widgets\BreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\components\widgets\MessagesWidget::class); ?>

    <?php echo $content; ?>

</section>
<?php $this->endContent(); ?>
