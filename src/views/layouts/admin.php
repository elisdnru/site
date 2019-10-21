<?php
use app\assets\AdminAsset;
use app\components\widgets\BreadcrumbsWidget;
use app\components\widgets\MessagesWidget;

AdminAsset::register(Yii::$app->view);
?>

<?php $this->beginContent('//layouts/main'); ?>

<section class="main" id="admin">

    <?= BreadcrumbsWidget::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?= MessagesWidget::widget() ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>
