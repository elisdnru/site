<?php

use app\components\widgets\Portlet;
use app\modules\user\forms\RegistrationForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/** @var $form CActiveForm */
/** @var $model RegistrationForm */
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

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <div class="row<?= $model->hasErrors('username') ? ' error' : '' ?> required">
            <?= Html::activeLabel($model, 'username') ?><br />
            <?= Html::activeTextInput($model, 'username', ['size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'username', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('email') ? ' error' : '' ?> required">
            <?= Html::activeLabel($model, 'email') ?><br />
            <?= Html::activeTextInput($model, 'email', ['type' => 'email', 'size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'email', ['class' => 'errorMessage']) ?>
        </div>

        <hr />

        <div class="row<?= $model->hasErrors('password') ? ' error' : '' ?> required">
            <?= Html::activeLabel($model, 'password') ?><br />
            <?= Html::activePasswordInput($model, 'password', ['size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'password', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('confirm') ? ' error' : '' ?> required">
            <?= Html::activeLabel($model, 'confirm') ?><br />
            <?= Html::activePasswordInput($model, 'confirm', ['size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'confirm', ['class' => 'errorMessage']) ?>
        </div>

        <hr />

        <div class="row<?= $model->hasErrors('lastname') ? ' error' : '' ?> required">
            <?= Html::activeLabel($model, 'lastname') ?><br />
            <?= Html::activeTextInput($model, 'lastname', ['size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'lastname', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('name') ? ' error' : '' ?> required">
            <?= Html::activeLabel($model, 'name') ?><br />
            <?= Html::activeTextInput($model, 'name', ['size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'name', ['class' => 'errorMessage']) ?>
        </div>

        <hr />

        <div class="row<?= $model->hasErrors('test') ? ' error' : '' ?> required">
            <?= Html::activeLabel($model, 'test') ?><br />
            <div>
                <?= Captcha::widget([
                    'model' => $model,
                    'attribute' => 'test1',
                    'captchaAction' => '/user/registration/captcha1',
                ]) ?>
            </div>
            <?= Html::error($model, 'test1', ['class' => 'errorMessage']) ?>
            <div>
                <?= Captcha::widget([
                    'model' => $model,
                    'attribute' => 'test2',
                    'captchaAction' => '/user/registration/captcha2',
                ]) ?>
            </div>
            <?= Html::error($model, 'test2', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row buttons">
            <br />
            <?= \yii\helpers\Html::submitButton('Зарегистрироваться') ?>
        </div>
    </form>

</div><!-- form -->

<?php Portlet::end(); ?>
