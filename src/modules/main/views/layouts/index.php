<?php $this->beginContent('//layouts/main'); ?>

<div class="main left_main">

    <?= \app\components\widgets\MessagesWidget::widget() ?>

    <?php echo $content; ?>

</div>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
