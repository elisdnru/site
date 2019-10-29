<?php
/** @var $form CActiveForm */

use app\components\widgets\Portlet;
use app\modules\user\forms\RemindForm;
use yii\helpers\Html;

/** @var $model RemindForm */
$this->context->layout = 'user';
$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'] = [
    'Вход на сайт' => ['login'],
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

    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <div class="row">
        <?= $form->labelEx($model, 'email') ?><br />
        <?= $form->textField($model, 'email', ['size' => 30]) ?><br />
        <?= $form->error($model, 'email') ?>
    </div>

    <div class="row buttons">
        <?= Html::submitButton('Восстановить пароль') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>
</div><!-- form -->

<?php Portlet::end(); ?>
