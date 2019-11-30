<?php

use app\assets\AdminAsset;
use app\widgets\BreadcrumbsWidget;
use app\widgets\MessagesWidget;

AdminAsset::register($this);
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<section class="main" id="admin">

    <?= BreadcrumbsWidget::widget([
        'links' => array_filter(array_merge(
            $this->context->route === 'admin/default/index' ? [] : ['Панель управления' => ['/admin']],
            $this->params['breadcrumbs']
        ))
    ]) ?>
    <?= MessagesWidget::widget() ?>

    <?= $content ?>

</section>

<?php $this->endContent(); ?>
