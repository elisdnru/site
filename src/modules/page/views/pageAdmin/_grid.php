<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => \app\modules\main\components\widgets\DIndentLinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \app\modules\main\components\widgets\DLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \app\modules\main\components\widgets\DButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->url',
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
