<?php

use app\components\widgets\Portlet;
use yii\helpers\Html;

/** @var $form CActiveForm */
/** @var $model \app\modules\user\forms\RegistrationForm */
$this->layout = '/layouts/user';
$this->title = 'Регистрация';
$this->params['breadcrumbs'] = [
    'Вход на сайт' => $this->createUrl('login'),
    'Регистрация',
];
?>

<?php Portlet::begin(['title' => 'Регистрация']); ?>

<div class="form">

    <form action="?" method="post">

        <?= Html::hiddenInput(Yii::app()->request->csrfTokenName, Yii::app()->request->getCsrfToken()) ?>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']) ?>

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

        <div class="row<?= $model->hasErrors('verifyCode') ? ' error' : '' ?> required">
            <?= Html::activeLabel($model, 'verifyCode') ?><br />
            <?= Html::activeTextInput($model, 'verifyCode', ['size' => 20, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'verifyCode', ['class' => 'errorMessage']) ?>
            <div>
                <?php Yii::app()->controller->widget(CCaptcha::class, ['buttonLabel' => '<br />Показать другой код<br />', 'captchaAction' => '/user/registration/captcha']); ?>
            </div>
        </div>

        <div class="row buttons">
            <br />
            <?= CHtml::submitButton('Зарегистрироваться') ?>
        </div>
    </form>

</div><!-- form -->

<?php Portlet::end(); ?>