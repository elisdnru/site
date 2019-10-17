<?php
use app\assets\AdminAsset;

AdminAsset::register(Yii::$app->view);
?>

<?php $this->beginContent('//layouts/main'); ?>

<section class="main" id="admin">

    <?php $this->widget(\app\components\widgets\BreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\components\widgets\MessagesWidget::class); ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>
