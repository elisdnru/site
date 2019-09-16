<?php use app\modules\main\widgets\DBreadcrumbsWidget;
use app\modules\main\widgets\DMessagesWidget;

$this->beginContent('//layouts/main'); ?>

<div class="main left_main">

    <?php $this->widget(DBreadcrumbsWidget::class); ?>
    <?php $this->widget(DMessagesWidget::class); ?>

    <?php echo $content; ?>

</div>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/sidebars/blog'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
