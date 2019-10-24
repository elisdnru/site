<?php
/** @var $form CActiveForm */
/** @var $model \app\modules\user\forms\LoginForm*/
$this->layout = '/layouts/user';
$this->title = 'Авторизация';
$this->params['breadcrumbs'] = [
    'Вход на сайт'
];

use app\components\widgets\Portlet;
use app\modules\ulogin\widgets\UloginWidget; ?>

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
        <?php echo $form->labelEx($model, 'username'); ?><br />
        <?php echo $form->textField($model, 'username', ['size' => 30]); ?><br />
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?><br />
        <?php echo $form->passwordField($model, 'password', ['size' => 30]); ?><br />
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="row rememberMe" style="margin-bottom: 10px">
        <?php echo $form->checkBox($model, 'rememberMe'); ?>
        <?php echo $form->label($model, 'rememberMe'); ?>
        <?php echo $form->error($model, 'rememberMe'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Вход в учётную запись'); ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>
</div><!-- form -->

<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Регистрация и восстановление']); ?>
<p style="margin:0;"><a href="<?php echo $this->createUrl('/user/default/registration'); ?>">Регистрация</a> |
    <a href="<?php echo $this->createUrl('/user/default/remind'); ?>">Забыли пароль?</a></p>
<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Вход через аккаунт в соцсети']); ?>
<?= UloginWidget::widget([
    'params' => ['redirect' => Yii::app()->createAbsoluteUrl('/ulogin/default/login', ['return' => ltrim(Yii::app()->getRequest()->getRequestUri(), '/')])]
]) ?>
<?php Portlet::end(); ?>
