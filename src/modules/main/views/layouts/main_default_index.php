<?php $this->beginContent('//layouts/main'); ?>

<section class="main left_main">

    <?php $this->widget(\app\modules\main\widgets\DMessagesWidget::class); ?>

    <?php echo $content; ?>

</section>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/sidebars/index'); ?>

    <div class="clear"></div>
</aside>

<?php $this->endContent(); ?>
