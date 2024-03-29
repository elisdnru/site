<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\user\forms\RegistrationForm;
use app\widgets\Portlet;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var RegistrationForm $model
 */
$this->context->layout = 'user';
$this->title = 'Регистрация';
$this->params['breadcrumbs'] = [
    'Вход на сайт' => ['default/login'],
    'Регистрация',
];
?>

<?php Portlet::begin(['title' => 'Регистрация']); ?>

<div class="form">

    <form action="?" method="post" id="register-form">

        <?= Csrf::hiddenInput(); ?>

        <div class="row<?= $model->hasErrors('username') ? ' error' : ''; ?> required">
            <?= Html::activeLabel($model, 'username'); ?><br />
            <?= Html::activeTextInput($model, 'username', ['size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'username', ['class' => 'error-message']); ?>
        </div>

        <div class="row<?= $model->hasErrors('email') ? ' error' : ''; ?> required">
            <?= Html::activeLabel($model, 'email'); ?><br />
            <?= Html::activeTextInput($model, 'email', ['type' => 'email', 'size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'email', ['class' => 'error-message']); ?>
        </div>

        <hr />

        <div class="row<?= $model->hasErrors('password') ? ' error' : ''; ?> required">
            <?= Html::activeLabel($model, 'password'); ?><br />
            <?= Html::activePasswordInput($model, 'password', ['size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'password', ['class' => 'error-message']); ?>
        </div>

        <div class="row<?= $model->hasErrors('confirm') ? ' error' : ''; ?> required">
            <?= Html::activeLabel($model, 'confirm'); ?><br />
            <?= Html::activePasswordInput($model, 'confirm', ['size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'confirm', ['class' => 'error-message']); ?>
        </div>

        <hr />

        <div class="row<?= $model->hasErrors('lastname') ? ' error' : ''; ?> required">
            <?= Html::activeLabel($model, 'lastname'); ?><br />
            <?= Html::activeTextInput($model, 'lastname', ['size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'lastname', ['class' => 'error-message']); ?>
        </div>

        <div class="row<?= $model->hasErrors('firstname') ? ' error' : ''; ?> required">
            <?= Html::activeLabel($model, 'firstname'); ?><br />
            <?= Html::activeTextInput($model, 'firstname', ['size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'firstname', ['class' => 'error-message']); ?>
        </div>

        <hr />

        <div class="row<?= $model->hasErrors('test') ? ' error' : ''; ?> required">
            <?= Html::activeLabel($model, 'test'); ?><br />
            <div>
                <?= Captcha::widget([
                    'model' => $model,
                    'attribute' => 'test1',
                    'captchaAction' => '/user/registration/captcha1',
                ]); ?>
            </div>
            <?= Html::error($model, 'test1', ['class' => 'error-message']); ?>
            <div>
                <?= Captcha::widget([
                    'model' => $model,
                    'attribute' => 'test2',
                    'captchaAction' => '/user/registration/captcha2',
                ]); ?>
            </div>
            <?= Html::error($model, 'test2', ['class' => 'error-message']); ?>
        </div>

        <div class="row buttons">
            <br />
            <?= Html::submitButton('Зарегистрироваться'); ?>
        </div>
    </form>

</div><!-- form -->

<?php Portlet::end(); ?>
