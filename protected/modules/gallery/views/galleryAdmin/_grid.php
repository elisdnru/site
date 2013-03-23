<?php
/* @var $this DAdminController */
/* @var $model Gallery */
?>

<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'alias',
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'class' => 'DLinkColumn',
            'name' => 'title',
        ),
        array(
            'class'=>'CButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{files}',
            'buttons'=>array(
                'files'=>array(
                    'url'=>'Yii::app()->controller->createUrl("files", array("id"=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl . '/core/images/admin/images.png',
                    'label'=>'Изображения',
                )
            )
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