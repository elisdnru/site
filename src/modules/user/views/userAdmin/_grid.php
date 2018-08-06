<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(50),
    'filter' => $model,
    'columns' => [
        [
            'class' => 'DImageLinkColumn',
            'value' => '$data->getAvatarUrl(50, 50)',
            'width' => 50,
            'htmlOptions' => ['style' => 'width:32px;text-align:center'],
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'username',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'email',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'class' => 'DLinkColumn',
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
            'class' => 'DButtonColumn',
            'template' => '{update}',
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{delete}',
        ],
    ],
]);
