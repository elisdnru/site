<?php use app\modules\main\widgets\DBreadcrumbsWidget;
use app\modules\main\widgets\DMessagesWidget;

$this->beginContent('//layouts/main'); ?>

<section class="main left_main">

    <?php $this->widget(DBreadcrumbsWidget::class); ?>
    <?php $this->widget(DMessagesWidget::class); ?>

    <?php echo $content; ?>

</section>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/sidebars/blog'); ?>

</aside>

<?php $this->endContent(); ?>
