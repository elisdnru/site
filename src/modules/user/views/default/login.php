<?php
/** @var $form ActiveForm */
/** @var $model LoginForm */
$this->context->layout = 'user';
$this->title = 'Авторизация';
$this->params['breadcrumbs'] = [
    'Вход на сайт'
];

use app\modules\user\forms\LoginForm;
use app\widgets\Portlet;
use app\modules\ulogin\widgets\UloginWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm; ?>

<h1>Вход в аккаунт</h1>

<?php Portlet::begin(['title' => 'Войти, используя логин и пароль']); ?>

<div class="form">

    <form action="?" method="post" id="login-form">

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <div class="row">
            <?= Html::activeLabel($model, 'username') ?><br />
            <?= Html::activeTextInput($model, 'username', ['size' => 30]) ?><br />
            <?= Html::error($model, 'username', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row">
            <?= Html::activeLabel($model, 'password') ?><br />
            <?= Html::activePasswordInput($model, 'password', ['size' => 30]) ?><br />
            <?= Html::error($model, 'password', ['class' => 'errorMessage']) ?>
        </div>
        <div class="row rememberMe" style="margin-bottom: 10px">
            <?= Html::activeCheckbox($model, 'rememberMe') ?><br />
            <?= Html::error($model, 'rememberMe', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row buttons">
            <?= Html::submitButton('Вход в учётную запись') ?>
        </div>

    </form>
</div><!-- form -->

<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Регистрация и восстановление']); ?>
<p style="margin:0;"><a href="<?= Url::to(['/user/registration/request']) ?>">Регистрация</a> |
    <a href="<?= Url::to(['/user/default/remind']) ?>">Забыли пароль?</a></p>
<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Вход через аккаунт в соцсети']); ?>
<?= UloginWidget::widget([
    'params' => ['redirect' => Url::to(['/ulogin/default/login', 'return' => ltrim(Yii::$app->request->getUrl(), '/')], true)]
]) ?>
<?php Portlet::end(); ?>
