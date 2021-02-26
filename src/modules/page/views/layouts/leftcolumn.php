<?php

use app\widgets\Breadcrumbs;
use app\widgets\Messages;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

$this->beginContent('@app/views/layouts/main.php');
?>

<aside class="sidebar left-sidebar">

    <?= $this->render('/layouts/_sidebar') ?>

    <div class="clear bottom-marker"></div>
</aside>

<div class="main right-main">

    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= Messages::widget() ?>

    <?= $content ?>

</div>

<?php $this->endContent(); ?>
