<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => \DIndentLinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \DLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \DButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->url',
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
