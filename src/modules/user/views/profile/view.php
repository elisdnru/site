<?php
use app\components\SocNetwork;
use app\modules\user\models\User;
use app\widgets\Portlet;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $user User */

$this->context->layout = 'user';
$this->title = 'Профиль пользователя ' . $user->username;
$this->params['breadcrumbs'] = ['Профиль'];

if (Yii::$app->user->can(Access::CONTROL)) {
    $this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['/user/admin/user/index']];
    $this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['/user/admin/user/update', 'id' => $user->id]];
}
?>

<?php Portlet::begin(['title' => 'Профиль пользователя']); ?>

<div style="float:left; margin-bottom:10px">
    <img src="<?= $user->avatarUrl ?>" alt="" width="50">
</div>

<div style="margin-left:60px;">

    <?php if ($user->id == Yii::$app->user->id) : ?>
        <p style="float:right">
            <a href="<?= Url::to(['edit']) ?>">Редактировать</a> |
            <a href="<?= Url::to(['password']) ?>">Сменить пароль</a> |
            <a href="<?= Url::to(['/user/default/logout']) ?>">Выход</a>
        </p>
    <?php endif; ?>

    <h3>
        <?php if ($user->network) : ?>
            <a rel="nofollow" href="<?= $user->identity ?>"><?= SocNetwork::icon($user->network) ?></a>
        <?php endif; ?>
        <?= Html::encode($user->fio) ?>
    </h3>
</div>

<div class="clear"></div>

<table class="detail-view">
    <tbody>
        <tr>
            <th style="width:150px; text-align:left">Логин</th>
            <td><?= Html::encode($user->username) ?></td>
        </tr>
        <tr>
            <th style="width:150px; text-align:left">Сайт</th>
            <td>
                <?php if ($user->site) : ?>
                    <?= Html::a(Html::encode($user->site), $user->site) ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th style="width:150px; text-align:left">Комментариев</th>
            <td><?= $user->getCommentsCount() ?></td>
        </tr>
    </tbody>
</table>
