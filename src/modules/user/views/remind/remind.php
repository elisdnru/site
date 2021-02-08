<?php

use app\components\Csrf;
use app\widgets\Portlet;
use app\modules\user\forms\RemindForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var RemindForm $model
 */
$this->context->layout = 'user';
$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'] = [
    'Вход на сайт' => ['default/login'],
    'Восстановление пароля',
];
?>

<?php Portlet::begin(['title' => 'Восстановление пароля']); ?>

<div class="form">

    <form action="?" method="post" id="remind-form">

        <?= Csrf::hiddenInput() ?>

        <div class="row">
            <?= Html::activeLabel($model, 'email') ?><br />
            <?= Html::activeTextInput($model, 'email', ['type' => 'email', 'size' => 30]) ?><br />
            <?= Html::error($model, 'email', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row buttons">
            <?= Html::submitButton('Восстановить пароль') ?>
        </div>

    </form>
</div><!-- form -->

<?php Portlet::end(); ?>
