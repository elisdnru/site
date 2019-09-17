<?php use app\modules\user\models\Access;

$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(50),
    'filter' => $model,
    'columns' => [
        [
            'class' => \app\modules\main\components\widgets\ImageLinkColumn::class,
            'value' => function ($data) {
                return $data->getAvatarUrl(50, 50);
            },
            'width' => 50,
            'htmlOptions' => ['style' => 'width:32px;text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\LinkColumn::class,
            'name' => 'username',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\LinkColumn::class,
            'name' => 'email',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\LinkColumn::class,
            'name' => 'fio',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'role',
            'value' => function ($data) { return Access::getRoleName($data->role); },
            'htmlOptions' => ['style' => 'text-align:center'],
            'filter' => Access::getRoles(),
        ],
        [
            'name' => 'create_datetime',
            'header' => 'Дата регистрации',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\ButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \app\modules\main\components\widgets\ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
