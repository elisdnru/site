<?php
/* @var $this DAdminController */
/* @var $model BlogPost */
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
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
            'name' => 'type_id',
            'filter' => ShopType::model()->getAssocList(),
            'htmlOptions'=>array('style'=>'text-align:center'),
            'value' => '$data->type ? $data->type->title : ""',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'inshort',
            'header'=>'С',
            'filter'=>array(1=>'Отображаемые и в списке', 0=>'Только в карточке товара'),
            'titles'=>array(1=>'В списке', 0=>'Только в карточке товара'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'offImageUrl' => Yii::app()->request->baseUrl . '/core/images/spacer.gif',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'template'=>'{update}',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'template'=>'{delete}',
        ),
    ),
)); ?>