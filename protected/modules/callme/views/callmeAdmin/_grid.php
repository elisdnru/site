
<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(50),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'date',
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'name' => 'name',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'name' => 'tel',
            'value' => 'CHtml::link(CHtml::encode($data->tel), Yii::app()->controller->createUrl("view", array("id"=>$data->id)))',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'type'  => 'html',
        ),
        array(
            'name' => 'text',
            'value' => 'CHtml::link(CHtml::encode(mb_substr($data->text, 0, 59, "UTF-8")), Yii::app()->controller->createUrl("view", array("id"=>$data->id)))',
            'type'  => 'html',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'readed',
            'header'=>'П',
            'filter'=>array(1=>'Прочитано', 0=>'Новое'),
            'titles'=>array(1=>'Прочитано', 0=>'Новое'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'offImageUrl' => Yii::app()->request->baseUrl . '/core/images/admin/message.png',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'called',
            'header'=>'З',
            'filter'=>array(1=>'Звонок произведён', 0=>'Звонок не произведён'),
            'titles'=>array(1=>'Звонок произведён', 0=>'Звонок не произведён'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'offImageUrl' => Yii::app()->request->baseUrl . '/core/images/spacer.gif',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{view}',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{delete}',
        ),
    ),
)); ?>