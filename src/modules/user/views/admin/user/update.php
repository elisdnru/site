<?php

use app\modules\user\forms\admin\EditForm;
use app\modules\user\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var User $model
 * @var ActiveForm $form
 * @var User $user
 * @var EditForm $model
 */

$this->title = 'Редактирование данных пользователя';
$this->params['breadcrumbs'] = [
    'Пользователи' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $model->id]];
?>

<h1>Редактирование пользователя</h1>

<div class="form">

    <form action="?" method="post" enctype="multipart/form-data">

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']) ?>

        <fieldset>
            <h4>Аккаунт</h4>

            <div class="row<?= $model->hasErrors('username') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'username') ?><br />
                <?= Html::activeTextInput($model, 'username') ?><br />
                <?= Html::error($model, 'username', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('email') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'email') ?><br />
                <?= Html::activeTextInput($model, 'email') ?><br />
                <?= Html::error($model, 'email', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('role') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'role') ?><br />
                <?= Html::activeDropDownList($model, 'role', $model->getRoles()) ?><br />
                <?= Html::error($model, 'role', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Анкета</h4>

            <div class="row<?= $model->hasErrors('lastname') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'lastname') ?><br />
                <?= Html::activeTextInput($model, 'lastname') ?><br />
                <?= Html::error($model, 'lastname', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('firstname') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'firstname') ?><br />
                <?= Html::activeTextInput($model, 'firstname') ?><br />
                <?= Html::error($model, 'firstname', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Аватар</h4>
            <div class="row<?= $model->hasErrors('avatar') ? ' error' : '' ?>">
                <p><img src="<?= $user->getAvatarUrl() ?>" width="50" alt="" /></p>
                <?= Html::activeFileInput($model, 'avatar') ?><br />
                <?= Html::error($model, 'avatar', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'del_avatar') ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Дополнительные атрибуты</h4>

            <div class="row<?= $model->hasErrors('site') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'site') ?><br />
                <?= Html::activeTextInput($model, 'site') ?><br />
                <?= Html::error($model, 'site', ['class' => 'errorMessage']) ?>
            </div>

        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>
    </form>

</div><!-- form -->
