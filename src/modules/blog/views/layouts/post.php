<?php

use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget;

$this->beginContent('//layouts/main'); ?>

<div class="main left_main">

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?php echo $content; ?>

</div>

<aside class="sidebar right_sidebar">

    <?php $this->renderPartial('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
