<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\user\forms\PasswordForm;
use app\modules\user\models\Access;
use app\widgets\Portlet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var PasswordForm $model
 */
$this->context->layout = 'user';
$this->title = 'Мой профиль';
$this->params['breadcrumbs'] = [
    'Мой профиль' => ['view'],
    'Смена пароля',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    $this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['/user/admin/user/index']];
} ?>

<?php Portlet::begin(['title' => 'Смена пароля']); ?>

<div class="form">

    <form action="?" method="post" id="password-form">

        <?= Csrf::hiddenInput(); ?>

        <div class="row required<?= $model->hasErrors('current') ? ' error' : ''; ?>">
            <?= Html::activeLabel($model, 'current'); ?> &nbsp;
            (<a target="_blank" href="<?= Url::to(['/user/remind/remind']); ?>">получить</a>)<br />
            <?= Html::activePasswordInput($model, 'current', ['size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'current', ['class' => 'error-message']); ?>
        </div>

        <div class="row required<?= $model->hasErrors('password') ? ' error' : ''; ?>">
            <?= Html::activeLabel($model, 'password'); ?><br />
            <?= Html::activePasswordInput($model, 'password', ['size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'password', ['class' => 'error-message']); ?>
        </div>

        <div class="row required<?= $model->hasErrors('confirm') ? ' error' : ''; ?>">
            <?= Html::activeLabel($model, 'confirm'); ?><br />
            <?= Html::activePasswordInput($model, 'confirm', ['size' => 40, 'maxlength' => 255]); ?><br />
            <?= Html::error($model, 'confirm', ['class' => 'error-message']); ?>
        </div>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

    </form>

</div><!-- form -->

<?php Portlet::end(); ?>
