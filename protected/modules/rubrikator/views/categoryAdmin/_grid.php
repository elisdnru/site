<?php
/* @var $this DAdminController */
/* @var $model BlogPost */
?>

<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(20),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DImageLinkColumn',
            'value' => '$data->image ? $data->imageUrl : ""',
            'width' => 32,
            'htmlOptions'=>array('style'=>'width:32px;text-align:center'),
        ),
        array(
            'name' => 'sort',
            'htmlOptions'=>array('style'=>'width:60px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'title',
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'alias',
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