<?php
/** @var $model \app\modules\block\models\Block */
?>
<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'alias',
            'header' => 'Код для вставки',
            'value' => static function ($data) {
                return Yii::app()->controller->InlineWidgetsBehavior->startBlock . 'block|id=' . $data->alias . Yii::app()->controller->InlineWidgetsBehavior->endBlock;
            },
        ],
        [
            'name' => 'title',
            'value' => static function ($data) {
                return CHtml::link(CHtml::encode($data->title), Yii::app()->controller->createUrl('update', ['id' => $data->id]));
            },
            'type' => 'html',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{view}',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
