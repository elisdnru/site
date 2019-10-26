<?php $this->beginContent('@app/views/layouts/main.php');

use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget; ?>

<div class="main left_main">

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?= $content ?>

</div>

<aside class="sidebar right_sidebar">

    <?= $this->render('/layouts/_sidebar') ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
