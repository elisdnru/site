<?php
/** @var $form CActiveForm */
/** @var $model \app\modules\user\forms\RemindForm */
$this->layout = '/layouts/user';
$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'] = [
    'Вход на сайт' => $this->createUrl('login'),
    'Восстановление пароля',
];
?>

<?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Восстановление пароля']); ?>

<?php if (Yii::app()->user->hasFlash('remind-message')) : ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('remind-message'); ?>
    </div>

<?php endif; ?>


<div class="form">
    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'id' => 'login-form',
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
