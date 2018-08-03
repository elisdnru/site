<?php $this->beginContent('//layouts/main'); ?>

<section class="main">

    <?php $this->widget('main.widgets.DBreadcrumbsWidget'); ?>
    <?php $this->widget('main.widgets.DMessagesWidget'); ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>