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
            'name' => 'frequency',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
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
