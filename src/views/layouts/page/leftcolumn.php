<?php $this->beginContent('//layouts/main'); ?>

<aside class="sidebar left_sidebar">

    <?php $this->renderPartial('//layouts/page/sidebars/default'); ?>

</aside>

<section class="main right_main">

    <?php $this->widget('main.widgets.DBreadcrumbsWidget'); ?>
    <?php $this->widget('main.widgets.DMessagesWidget'); ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>
