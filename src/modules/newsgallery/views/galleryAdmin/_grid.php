<?php
/* @var $this DAdminController */
/* @var $model NewsGallery */
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
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
            'class'=>'DButtonColumn',
            'template'=>'{files}',
            'buttons'=>array(
                'files'=>array(
                    'url'=>'Yii::app()->controller->createUrl("files", array("id"=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl . '/images/admin/images.png',
                    'label'=>'Изображения',
                )
            )
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