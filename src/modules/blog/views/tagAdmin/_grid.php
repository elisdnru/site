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
            'name' => 'frequency',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
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
