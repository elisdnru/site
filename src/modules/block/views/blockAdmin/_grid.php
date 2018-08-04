
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name' => 'alias',
            'header' => 'Код для вставки',
            'value' => 'Yii::app()->controller->DInlineWidgetsBehavior->startBlock . "block|id=" . $data->alias . Yii::app()->controller->DInlineWidgetsBehavior->endBlock',
        ),
        array(
            'name' => 'title',
            'value' => 'CHtml::link(CHtml::encode($data->title), Yii::app()->controller->createUrl("update", array("id"=>$data->id)))',
            'type'  => 'html',
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{view}',
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{update}',
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{delete}',
        ),
    ),
)); ?>