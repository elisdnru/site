<?php $this->beginContent('//layouts/main');

use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget; ?>

<aside class="sidebar left_sidebar">

    <?= $this->renderPartial('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<div class="main right_main">

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?= $content ?>

</div>

<?php $this->endContent(); ?>
