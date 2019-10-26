<?php
use app\assets\AdminAsset;
use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget;

AdminAsset::register($this);
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<section class="main" id="admin">

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?= $content ?>

</section>

<?php $this->endContent(); ?>
