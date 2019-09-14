<?php $this->beginContent('//layouts/main'); ?>
<section class="main">

    <?php $this->widget(\DBreadcrumbsWidget::class); ?>
    <?php $this->widget(\DMessagesWidget::class); ?>

    <?php echo $content; ?>

</section>
<?php $this->endContent(); ?>
