<?php $this->beginContent('//layouts/main'); ?>

<section class="main left_main">

    <?php $this->widget('block.widgets.BlockWidget', ['id' => 'banner_blog_top']); ?>

    <?php $this->widget('main.widgets.DBreadcrumbsWidget'); ?>
    <?php $this->widget('main.widgets.DMessagesWidget'); ?>

    <?php echo $content; ?>

    <?php $this->widget('block.widgets.BlockWidget', ['id' => 'banner_blog_bottom']); ?>

</section>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/sidebars/blog'); ?>

</aside>

<?php $this->endContent(); ?>
