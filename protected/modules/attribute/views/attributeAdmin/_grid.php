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
            'name'=>'sort',
            'htmlOptions'=>array('style'=>'width:60px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'label',
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'name',
        ),
        array(
            'name'=>'class',
            'filter'=>array('User'=>'Пользователь'),
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'name' => 'type',
            'value' => 'UserAttribute::getTypeName($data->type)',
            'filter' => UserAttribute::getTypes(),
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'name' => 'type',
            'value' => 'UserAttribute::getRuleName($data->rule)',
            'filter' => UserAttribute::getRules(),
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'required',
            'header'=>'О',
            'filter'=>array(1=>'Обязательный', 0=>'Необязательный'),
            'titles'=>array(1=>'Обязательный', 0=>'Необязательный'),
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