<?php

use app\modules\user\forms\ProfileForm;
use app\modules\user\models\User;
use app\widgets\Portlet;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $form ActiveForm */
/** @var $user User */
/** @var $model ProfileForm */

$this->context->layout = 'user';
$this->title = 'Мой профиль';
$this->params['breadcrumbs'] = [
    'Мой профиль' => ['view'],
    'Редактирование'
];

if (Yii::$app->user->can(Access::CONTROL)) {
    $this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['/user/admin/user/index']];
} ?>

<?php Portlet::begin(['title' => 'Редактировать профиль']); ?>

<div class="form">

    <form action="?" method="post" enctype="multipart/form-data" id="profile-form">

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <div>
            <div class="row required <?= $model->hasErrors('lastname') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'lastname') ?><br />
                <?= Html::activeTextInput($model, 'lastname', ['size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'lastname', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row required <?= $model->hasErrors('firstname') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'firstname') ?><br />
                <?= Html::activeTextInput($model, 'firstname', ['size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'firstname', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('site') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'site') ?><br />
                <?= Html::activeTextInput($model, 'site', ['type' => 'url', 'size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'site', ['class' => 'errorMessage']) ?>
            </div>

            <hr />

            <div class="row">
                <p style="float:right"><img src="<?= $user->getAvatarUrl() ?>" alt="" width="50" height="50"></p>
                <?= Html::activeLabel($model, 'avatar') ?><br />
                <?= Html::activeTextInput($model, 'avatar', ['type' => 'file', 'size' => 30]) ?>
                <?= Html::error($model, 'avatar') ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'del_avatar') ?>
            </div>

        <hr />

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>
    </div>

    </form>

</div><!-- form -->

<?php Portlet::end(); ?>
