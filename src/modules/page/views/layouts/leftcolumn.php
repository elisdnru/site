<?php $this->beginContent('@app/views/layouts/main.php');

use app\widgets\Breadcrumbs;
use app\widgets\Messages; ?>

<aside class="sidebar left_sidebar">

    <?= $this->render('/layouts/_sidebar') ?>

    <div class="clear bottom-marker"></div>
</aside>

<div class="main right_main">

    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= Messages::widget() ?>

    <?= $content ?>

</div>

<?php $this->endContent(); ?>
