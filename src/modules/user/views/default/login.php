<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\ulogin\widgets\ULoginWidget;
use app\modules\user\forms\LoginForm;
use app\modules\user\widgets\OAuthWidget;
use app\widgets\Portlet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var LoginForm $model
 */
$request = Yii::$app->request;

$this->context->layout = 'user';
$this->title = 'Авторизация';
$this->params['breadcrumbs'] = [
    'Вход на сайт',
];
?>

<h1>Вход в аккаунт</h1>

<?php Portlet::begin(['title' => 'Войти, используя логин и пароль']); ?>

<div class="form">

    <form action="?" method="post" id="login-form">

        <?= Csrf::hiddenInput(); ?>

        <div class="row">
            <?= Html::activeLabel($model, 'username'); ?><br />
            <?= Html::activeTextInput($model, 'username', ['size' => 30]); ?><br />
            <?= Html::error($model, 'username', ['class' => 'error-message']); ?>
        </div>

        <div class="row">
            <?= Html::activeLabel($model, 'password'); ?><br />
            <?= Html::activePasswordInput($model, 'password', ['size' => 30]); ?><br />
            <?= Html::error($model, 'password', ['class' => 'error-message']); ?>
        </div>
        <div class="row rememberMe" style="margin-bottom: 10px">
            <?= Html::activeCheckbox($model, 'rememberMe'); ?><br />
            <?= Html::error($model, 'rememberMe', ['class' => 'error-message']); ?>
        </div>

        <div class="row buttons">
            <?= Html::submitButton('Вход в учётную запись'); ?>
        </div>

    </form>
</div><!-- form -->

<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Регистрация и восстановление']); ?>
<p style="margin:0;"><a href="<?= Url::to(['/user/registration/request']); ?>">Регистрация</a> |
    <a href="<?= Url::to(['/user/remind/remind']); ?>">Забыли пароль?</a></p>
<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Вход через аккаунт в соцсети']); ?>
<?php if (Yii::$app->features->isActive('OAUTH')): ?>
    <?= OAuthWidget::widget([
        'return' => Yii::$app->request->getUrl(),
    ]); ?>
<?php else: ?>
    <?= ULoginWidget::widget([
        'redirect' => Url::to(['/ulogin/default/login', 'return' => ltrim($request->getUrl(), '/')], true),
    ]); ?>
<?php endif; ?>
<?php Portlet::end(); ?>
