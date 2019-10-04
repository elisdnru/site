<?php

use app\modules\user\models\Access;

$this->pageTitle = 'Регистрация';
$this->breadcrumbs = [
    'Вход на сайт' => $this->createUrl('login'),
    'Регистрация',
];
?>

<?php $this->beginWidget(\app\modules\main\components\widgets\Portlet::class, ['title' => 'Регистрация']); ?>

<div class="form">
    <?php Yii::app()->clientScript->registerCoreScript('form'); ?>
    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'id' => 'register-form',
        'enableAjaxValidation' => false,
    ]); ?>

    <?php if (Yii::app()->user->hasFlash('register-form')) : ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('register-form'); ?>
        </div>

    <?php endif; ?>

    <?php echo $form->errorSummary($model, '<b>Во время регистрации обнаружены ошибки:</b><br /><br />'); ?>

    <div>
        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?><br />
            <?php echo $form->textField($model, 'username', ['size' => 40, 'maxlength' => 255]); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?><br />
            <?php echo $form->textField($model, 'email', ['size' => 40, 'maxlength' => 255]); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'new_password'); ?><br />
            <?php echo $form->passwordField($model, 'new_password', ['size' => 40, 'maxlength' => 255]); ?>
            <?php echo $form->error($model, 'new_password'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'new_confirm'); ?><br />
            <?php echo $form->passwordField($model, 'new_confirm', ['size' => 40, 'maxlength' => 255]); ?>
            <?php echo $form->error($model, 'new_confirm'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'lastname'); ?><br />
            <?php echo $form->textField($model, 'lastname', ['size' => 40, 'maxlength' => 255]); ?>
            <?php echo $form->error($model, 'lastname'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?><br />
            <?php echo $form->textField($model, 'name', ['size' => 40, 'maxlength' => 255]); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'middlename'); ?><br />
            <?php echo $form->textField($model, 'middlename', ['size' => 40, 'maxlength' => 255]); ?>
            <?php echo $form->error($model, 'middlename'); ?>
        </div>

        <?php if (!$this->is(Access::ROLE_ADMIN)) : ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'verifyCode'); ?><br />
                <?php echo $form->textField($model, 'verifyCode', ['size' => 20]); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
                <div>
                    <?php $this->widget(\CCaptcha::class, ['buttonLabel' => '<br />Показать другой код<br />', 'captchaAction' => '/user/default/captcha']); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="row buttons">
            <br />
            <?php echo CHtml::submitButton('Зарегистрироваться'); ?>
        </div>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>
