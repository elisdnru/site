<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => \DLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \DLinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \DButtonColumn::class,
            'template' => '{view}',
        ],
        [
            'class' => \DButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \DButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
