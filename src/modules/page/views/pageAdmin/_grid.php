<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => 'DIndentLinkColumn',
            'name' => 'alias',
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'title',
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => '$data->url',
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
