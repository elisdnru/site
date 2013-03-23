<?php $this->beginContent('//layouts/main'); ?>

<section class="main left_main">

    <?php $this->widget('main.widgets.DBreadcrumbsWidget'); ?>
    <?php $this->widget('main.widgets.DMessagesWidget'); ?>

    <?php echo $content; ?>

</section>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('//layouts/page/sidebars/default'); ?>

</aside>

<?php $this->endContent(); ?>