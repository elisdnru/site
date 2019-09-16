<?php use app\modules\user\models\Access;

$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(50),
    'filter' => $model,
    'columns' => [
        [
            'class' => \app\modules\main\components\widgets\DImageLinkColumn::class,
            'value' => '$data->getAvatarUrl(50, 50)',
            'width' => 50,
            'htmlOptions' => ['style' => 'width:32px;text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\DLinkColumn::class,
            'name' => 'username',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\DLinkColumn::class,
            'name' => 'email',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\DLinkColumn::class,
            'name' => 'fio',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'role',
            'value' => 'Access::getRoleName($data->role)',
            'htmlOptions' => ['style' => 'text-align:center'],
            'filter' => Access::getRoles(),
        ],
        [
            'name' => 'create_datetime',
            'header' => 'Дата регистрации',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\DButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \app\modules\main\components\widgets\DButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
