<?php use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget;

$this->beginContent('//layouts/main'); ?>

<div class="main left_main">

    <?php $this->widget(BreadcrumbsWidget::class); ?>
    <?php $this->widget(MessagesWidget::class); ?>

    <?php echo $content; ?>

</div>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/sidebars/blog'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
