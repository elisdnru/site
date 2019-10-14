<?php
use app\modules\user\models\Access;
/** @var $model \app\modules\user\models\User */
?>
<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(50),
    'filter' => $model,
    'columns' => [
        [
            'class' => \app\components\widgets\grid\ImageLinkColumn::class,
            'value' => static function (\app\modules\user\models\User $data) {
                return $data->getAvatarUrl(50, 50);
            },
            'width' => 50,
            'htmlOptions' => ['style' => 'width:32px;text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'username',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'email',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'fio',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'role',
            'value' => static function ($data) { return Access::getRoleName($data->role); },
            'htmlOptions' => ['style' => 'text-align:center'],
            'filter' => Access::getRoles(),
        ],
        [
            'name' => 'create_datetime',
            'header' => 'Дата регистрации',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
