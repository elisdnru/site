<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{view}',
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
