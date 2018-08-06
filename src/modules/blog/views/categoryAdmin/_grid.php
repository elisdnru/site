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
            'class' => 'DIndentLinkColumn',
            'name' => 'title',
        ],
        [
            'class' => 'DLinkColumn',
            'name' => 'alias',
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
