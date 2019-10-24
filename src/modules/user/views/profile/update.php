<?php

use app\components\widgets\Portlet;
use app\modules\user\models\Access;
use yii\helpers\Html;

/** @var $form CActiveForm */
/** @var $model \app\modules\user\models\User */
$this->layout = '/layouts/user';
$this->title = 'Мой профиль';
$this->params['breadcrumbs'] = [
    'Мой профиль' => ['view'],
    'Редактирование'
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    $this->params['admin'][] = ['label' => 'Пользователи', 'url' => $this->createUrl('/user/admin/user/index')];
} ?>

<?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Редактировать профиль']); ?>

<div class="form">

    <form action="?" method="post" enctype="multipart/form-data">

        <?= Html::hiddenInput(Yii::app()->request->csrfTokenName, Yii::app()->request->getCsrfToken()) ?>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']) ?>

        <div>
            <h4>Пользователь</h4>

            <hr />

            <div class="row<?= $model->hasErrors('lastname') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'lastname') ?><br />
                <?= Html::activeTextInput($model, 'lastname', ['size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'lastname', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('name') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'name') ?><br />
                <?= Html::activeTextInput($model, 'name', ['size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'name', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('middlename') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'middlename') ?><br />
                <?= Html::activeTextInput($model, 'middlename', ['size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'middlename', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('site') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'site') ?><br />
                <?= Html::activeTextInput($model, 'site', ['type' => 'url', 'size' => 40, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'site', ['class' => 'errorMessage']) ?>
            </div>

            <hr />

            <h4>Аватар</h4>

            <div class="row">
                <p style="float:right"><img src="<?php echo $model->getAvatarUrl(); ?>" alt="" width="50" height="50"></p>
                <?= Html::activeLabel($model, 'avatar') ?><br />
                <?= Html::activeFileInput($model, 'avatar', ['size' => 30]) ?><label>
                    <?= Html::error($model, 'avatar') ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'del_avatar') ?>
            </div>

        <hr />

        <h4>Смена пароля</h4>

        <div class="row<?= $model->hasErrors('old_password') ? ' error' : '' ?>">
            <?= Html::activeLabel($model, 'old_password') ?> &nbsp;
            (<a target="_blank" href="<?php echo $this->createUrl('/user/default/remind'); ?>">получить</a>)<br />
            <?= Html::activePasswordInput($model, 'old_password', ['size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'old_password', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('new_password') ? ' error' : '' ?>">
            <?= Html::activeLabel($model, 'new_password') ?><br />
            <?= Html::activePasswordInput($model, 'new_password', ['size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'new_password', ['class' => 'errorMessage']) ?>
        </div>

        <div class="row<?= $model->hasErrors('new_confirm') ? ' error' : '' ?>">
            <?= Html::activeLabel($model, 'new_confirm') ?><br />
            <?= Html::activePasswordInput($model, 'new_confirm', ['size' => 40, 'maxlength' => 255]) ?><br />
            <?= Html::error($model, 'new_confirm', ['class' => 'errorMessage']) ?>
        </div>

        <hr />

        <div class="row buttons">
            <?php echo CHtml::submitButton('Сохранить'); ?>
        </div>
    </div>

    </form>

</div><!-- form -->


<?php Yii::app()->controller->endWidget(); ?>
