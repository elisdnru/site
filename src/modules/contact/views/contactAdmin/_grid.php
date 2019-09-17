<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(50),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'date',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'name' => 'name',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'email',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'text',
            'value' => function ($data) {
                return CHtml::link(CHtml::encode(mb_substr($data->text, 0, 59, 'UTF-8')), Yii::app()->controller->createUrl('view', ['id' => $data->id]));
            },
            'type' => 'html',
        ],
        [
            'name' => 'pagetitle',
        ],
        [
            'class' => \app\modules\main\components\widgets\ToggleColumn::class,
            'name' => 'status',
            'header' => 'П',
            'filter' => [1 => 'Прочитано', 0 => 'Новое'],
            'titles' => [1 => 'Прочитано', 0 => 'Новое'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
            'offImageUrl' => '/images/admin/message.png',
        ],
        [
            'class' => \app\modules\main\components\widgets\ButtonColumn::class,
            'template' => '{view}',
        ],
        [
            'class' => \app\modules\main\components\widgets\ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
