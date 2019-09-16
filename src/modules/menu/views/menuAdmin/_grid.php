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
            'class' => \app\modules\main\components\widgets\DIndentLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \app\modules\main\components\widgets\DLinkColumn::class,
            'name' => 'link',
        ],
        [
            'class' => \app\modules\main\components\widgets\DLinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \app\modules\main\components\widgets\DToggleColumn::class,
            'name' => 'visible',
            'header' => 'В',
            'filter' => [1 => 'Видимые', 0 => 'Скрытые'],
            'titles' => [1 => 'Видимо', 0 => 'Скрыто'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\DButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->link',
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
