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
