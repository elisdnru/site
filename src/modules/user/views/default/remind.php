<?php
/** @var $form CActiveForm */

use app\components\widgets\Portlet;
use app\modules\user\forms\RemindForm;

/** @var $model RemindForm */
$this->layout = '/layouts/user';
$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'] = [
    'Вход на сайт' => $this->createUrl('login'),
    'Восстановление пароля',
];
?>

<?php Portlet::begin(['title' => 'Восстановление пароля']); ?>

<div class="form">
    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <div class="row">
        <?= $form->labelEx($model, 'email') ?><br />
        <?= $form->textField($model, 'email', ['size' => 30]) ?><br />
        <?= $form->error($model, 'email') ?>
    </div>

    <div class="row buttons">
        <?= CHtml::submitButton('Восстановить пароль') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>
</div><!-- form -->

<?php Portlet::end(); ?>
