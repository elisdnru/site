<?php
/* @var $this DAdminController */
/* @var $model BlogPost */
?>

<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class' => 'DImageLinkColumn',
            'value' => '$data->image ? $data->imageUrl : ""',
            'width' => 100,
            'htmlOptions'=>array('style'=>'width:100px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'title',
        ),
        array(
            'filter' => CHtml::listData(ShopProduct::model()->findAll(), 'id', 'title'),
            'name' => 'product_id',
            'value' => '$data->product ? CHtml::link(CHtml::encode($data->product->title), $data->product->url) : ""',
            'type'=>'html',
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