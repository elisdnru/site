<?php
use app\widgets\Breadcrumbs;
use app\widgets\Messages;
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<div class="main left_main">

    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= Messages::widget() ?>

    <?= $content ?>

</div>

<aside class="sidebar right_sidebar">

    <?= $this->render('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
