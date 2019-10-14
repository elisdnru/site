<?php

use app\components\helpers\SocNetworkHelper;
use app\modules\user\models\Access;

/** @var $model \app\modules\user\models\User */

$this->layout = '/layouts/user';
$this->pageTitle = 'Профиль пользователя ' . $model->username;
$this->breadcrumbs = ['Профиль'];

if ($this->is(Access::ROLE_CONTROL)) {
    $this->admin[] = ['label' => 'Пользователи', 'url' => $this->createUrl('/user/admin/user/index')];
    $this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('/user/admin/user/update', ['id' => $model->id])];
}
?>

<?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Профиль пользователя']); ?>

<div style="float:left; margin-bottom:10px">
    <img src="<?php echo $model->avatarUrl; ?>" alt="" width="50" />
</div>

<div style="margin-left:60px;">

    <?php if ($model->id == Yii::app()->user->id) : ?>
        <p style="float:right">
            <a href="<?php echo $this->createUrl('/user/profile/edit'); ?>">Редактировать</a> |
            <a href="<?php echo $this->createUrl('/user/default/logout'); ?>">Выход</a>
        </p>
    <?php endif; ?>

    <h3>
        <?php if ($model->network) : ?>
            <a rel="nofollow" href="<?php echo $model->identity; ?>"><?php echo SocNetworkHelper::getIcon($model->network); ?></a>
        <?php endif; ?>
        <?php echo CHtml::encode($model->fio); ?>
    </h3>
</div>

<div class="clear"></div>

<?php
$this->widget('zii.widgets.CDetailView', [
    'data' => $model,
    'tagName' => 'table',
    'itemTemplate' => "<tr><th style=\"width:150px; text-align:left\">{label}</th><td>{value}</td></tr>\n",
    'htmlOptions' => ['class' => 'detail-view nomargin'],
    'cssFile' => false,
    'attributes' => [
        'username',
        [
            'label' => 'Сайт',
            'type' => 'html',
            'value' => CHtml::link(CHtml::encode($model->site), $model->site),
            'visible' => $model->site,
        ],
        [
            'label' => 'Комментариев',
            'type' => 'html',
            'value' => $model->comments_count,
            'visible' => $model->comments_count,
        ],
    ],
]);
?>

<?php $this->endWidget(); ?>


