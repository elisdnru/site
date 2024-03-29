<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\user\forms\ProfileForm;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use app\widgets\Portlet;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var User $user
 * @var ProfileForm $model
 */
$this->context->layout = 'user';
$this->title = 'Мой профиль';
$this->params['breadcrumbs'] = [
    'Мой профиль' => ['view'],
    'Редактирование',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    $this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['/user/admin/user/index']];
} ?>

<?php Portlet::begin(['title' => 'Редактировать профиль']); ?>

<div class="form">

    <form action="?" method="post" enctype="multipart/form-data" id="profile-form">

        <?= Csrf::hiddenInput(); ?>

        <div>
            <div class="row required <?= $model->hasErrors('lastname') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'lastname'); ?><br />
                <?= Html::activeTextInput($model, 'lastname', ['size' => 40, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'lastname', ['class' => 'error-message']); ?>
            </div>

            <div class="row required <?= $model->hasErrors('firstname') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'firstname'); ?><br />
                <?= Html::activeTextInput($model, 'firstname', ['size' => 40, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'firstname', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('site') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'site'); ?><br />
                <?= Html::activeTextInput($model, 'site', ['type' => 'url', 'size' => 40, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'site', ['class' => 'error-message']); ?>
            </div>

            <hr />

            <div class="row">
                <p style="float:right"><img src="<?= $user->getAvatarUrl(); ?>" alt="" width="50" height="50"></p>
                <?= Html::activeLabel($model, 'avatar'); ?><br />
                <?= Html::activeTextInput($model, 'avatar', ['type' => 'file', 'size' => 30]); ?>
                <?= Html::error($model, 'avatar', ['class' => 'error-message']); ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'del_avatar'); ?>
            </div>

        <hr />

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>
    </div>

    </form>

</div><!-- form -->

<?php Portlet::end(); ?>
