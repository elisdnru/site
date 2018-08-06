<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => 'DLinkColumn',
            'name' => 'title',
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'alias',
        ],
        [
            'class' => 'DButtonColumn',
            'template' => '{view}',
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
