<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'sort',
            'htmlOptions' => ['style' => 'width:50px;text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\IndentLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'link',
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \app\components\widgets\grid\ToggleColumn::class,
            'name' => 'visible',
            'header' => 'В',
            'filter' => [1 => 'Видимые', 0 => 'Скрытые'],
            'titles' => [1 => 'Видимо', 0 => 'Скрыто'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->link',
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
