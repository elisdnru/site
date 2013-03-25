
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'sort',
            'htmlOptions'=>array('style'=>'width:50px;text-align:center'),
        ),
        array(
            'name' => 'title',
            'value' => 'CHtml::link(CHtml::encode($data->title), Yii::app()->controller->createUrl("update", array("id"=>$data->id)))',
            'type'  => 'html',
        ),
        array(
            'name' => 'url',
            'value' => 'CHtml::link(CHtml::encode($data->url), Yii::app()->controller->createUrl("update", array("id"=>$data->id)))',
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