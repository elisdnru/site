
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'date',
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'name',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'moder',
            'header'=>'М',
            'filter'=>array(1=>'Проверен', 0=>'Не проверен'),
            'titles'=>array(1=>'Проверен', 0=>'Не проверен'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
            'offImageUrl' => Yii::app()->request->baseUrl . '/core/images/spacer.gif',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'public',
            'header'=>'О',
            'filter'=>array(1=>'Опубликовано', 0=>'Не опубликовано'),
            'titles'=>array(1=>'Опубликовано', 0=>'Не опубликовано'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
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