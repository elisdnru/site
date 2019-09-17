<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'alias',
            'header' => 'Код для вставки',
            'value' => 'Yii::app()->controller->DInlineWidgetsBehavior->startBlock . "block|id=" . $data->alias . Yii::app()->controller->DInlineWidgetsBehavior->endBlock',
        ],
        [
            'name' => 'title',
            'value' => 'CHtml::link(CHtml::encode($data->title), Yii::app()->controller->createUrl("update", array("id"=>$data->id)))',
            'type' => 'html',
        ],
        [
            'class' => \app\modules\main\components\widgets\ButtonColumn::class,
            'template' => '{view}',
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
