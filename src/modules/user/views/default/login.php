<?php
/** @var $form CActiveForm */
/** @var $model \app\modules\user\forms\LoginForm*/
$this->context->layout = 'user';
$this->title = 'Авторизация';
$this->params['breadcrumbs'] = [
    'Вход на сайт'
];

use app\components\widgets\Portlet;
use app\modules\ulogin\widgets\UloginWidget;
use yii\helpers\Url; ?>

<h1>Вход в аккаунт</h1>

<?php Portlet::begin(['title' => 'Войти, используя логин и пароль']); ?>

<div class="form">
    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <div class="row">
        <?= $form->labelEx($model, 'username') ?><br />
        <?= $form->textField($model, 'username', ['size' => 30]) ?><br />
        <?= $form->error($model, 'username') ?>
    </div>

    <div class="row">
        <?= $form->labelEx($model, 'password') ?><br />
        <?= $form->passwordField($model, 'password', ['size' => 30]) ?><br />
        <?= $form->error($model, 'password') ?>
    </div>
    <div class="row rememberMe" style="margin-bottom: 10px">
        <?= $form->checkBox($model, 'rememberMe') ?>
        <?= $form->label($model, 'rememberMe') ?>
        <?= $form->error($model, 'rememberMe') ?>
    </div>

    <div class="row buttons">
        <?= CHtml::submitButton('Вход в учётную запись') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>
</div><!-- form -->

<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Регистрация и восстановление']); ?>
<p style="margin:0;"><a href="<?= Url::to(['/user/registration/request']) ?>">Регистрация</a> |
    <a href="<?= Url::to(['/user/default/remind']) ?>">Забыли пароль?</a></p>
<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Вход через аккаунт в соцсети']); ?>
<?= UloginWidget::widget([
    'params' => ['redirect' => Url::to(['/ulogin/default/login', 'return' => ltrim(Yii::app()->getRequest()->getRequestUri(), '/')], true)]
]) ?>
<?php Portlet::end(); ?>
