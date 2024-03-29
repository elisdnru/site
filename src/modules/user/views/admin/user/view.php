<?php declare(strict_types=1);

use app\components\SocNetwork;
use app\modules\user\models\User;
use app\widgets\Portlet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var User $model
 */
$this->title = 'Профиль пользователя ' . $model->username;
$this->params['breadcrumbs'] = [
    'Пользователи' => ['index'],
    $model->username => ['view', 'id' => $model->id],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['update', 'id' => $model->id]];
?>

<?php Portlet::begin(['title' => 'Профиль пользователя']); ?>

<div style="float:left; margin-bottom:10px">
    <img src="<?= $model->getAvatarUrl(); ?>" alt="" width="50">
</div>

<div style="margin-left:60px;">

    <?php if ($model->id === Yii::$app->user->id): ?>
        <p style="float:right">
            <a href="<?= Url::to(['/user/profile/edit']); ?>">Редактировать</a> |
            <a href="<?= Url::to(['/user/default/logout']); ?>">Выход</a>
        </p>
    <?php endif; ?>

    <h3>
        <?php if ($model->network): ?>
            <a rel="nofollow" href="<?= $model->identity; ?>"><?= SocNetwork::icon($model->network); ?></a>
        <?php endif; ?>
        <?= Html::encode($model->getFio()); ?>
    </h3>
</div>

<div class="clear"></div>

<table class="detail-view">
    <tbody>
        <tr>
            <th style="width:150px; text-align:left">Username</th>
            <td><?= Html::encode($model->username); ?></td>
        </tr>
        <tr>
            <th style="width:150px; text-align:left">Сайт</th>
            <td>
                <?php if ($model->site): ?>
                    <?= Html::a(Html::encode($model->site), $model->site); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th style="width:150px; text-align:left">Комментариев</th>
            <td><?= $model->getCommentsCount(); ?></td>
        </tr>
    </tbody>
</table>
