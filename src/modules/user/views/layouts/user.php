<?php
use app\widgets\Breadcrumbs;
use app\widgets\Messages;

/** @var string $content */

$this->beginContent('@app/views/layouts/main.php');
?>

<section class="main">

    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= Messages::widget() ?>

    <?= $content ?>

</section>

<?php $this->endContent(); ?>
