
<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(),
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
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{view}',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{update}',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{delete}',
        ),
    ),
)); ?>