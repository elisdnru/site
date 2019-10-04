<?php
$this->pageTitle = 'Восстановление пароля';
$this->breadcrumbs = [
    'Вход на сайт' => $this->createUrl('login'),
    'Восстановление пароля',
];
?>

<?php $this->beginWidget(\app\modules\main\components\widgets\Portlet::class, ['title' => 'Восстановление пароля']); ?>

<?php if (Yii::app()->user->hasFlash('remind-message')) : ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('remind-message'); ?>
    </div>

<?php endif; ?>


<div class="form">
    <?php Yii::app()->clientScript->registerCoreScript('form'); ?>
    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'id' => 'login-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?><br />
        <?php echo $form->textField($model, 'email', ['size' => 30]); ?><br />
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Восстановить пароль'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php $this->endWidget(); ?>
