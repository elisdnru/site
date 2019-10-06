<?php $this->beginContent('//layouts/main'); ?>

<?php Yii::app()->clientScript->registerPackage('form'); ?>
<?php Yii::app()->clientScript->registerPackage('admin'); ?>

<section class="main" id="admin">

    <?php $this->widget(\app\components\widgets\BreadcrumbsWidget::class); ?>
    <?php $this->widget(\app\components\widgets\MessagesWidget::class); ?>

    <?php echo $content; ?>

</section>

<?php $this->endContent(); ?>
