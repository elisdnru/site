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
            'class' => \app\modules\main\components\widgets\IndentLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \app\modules\main\components\widgets\LinkColumn::class,
            'name' => 'link',
        ],
        [
            'class' => \app\modules\main\components\widgets\LinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \app\modules\main\components\widgets\ToggleColumn::class,
            'name' => 'visible',
            'header' => 'В',
            'filter' => [1 => 'Видимые', 0 => 'Скрытые'],
            'titles' => [1 => 'Видимо', 0 => 'Скрыто'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\ButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->link',
        ],
        [
            'class' => \app\modules\main\components\widgets\ButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \app\modules\main\components\widgets\ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
