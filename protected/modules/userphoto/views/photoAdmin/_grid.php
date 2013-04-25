
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DLinkColumn',
            'name' => 'id',
            'htmlOptions'=>array('style'=>'width:80px;text-align:center'),
        ),
        array(
            'class'=>'DImageLinkColumn',
            'value' => '$data->file ? $data->getImageThumbUrl(150, 150) : ""',
            'width' => 150,
            'height' => 150,
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'title',
        ),
        array(
            'name' => 'text',
            'value' => 'mb_substr($data->text, 0, 100, "UTF-8") . " ..."'
        ),
        array(
            'name' => 'user_id',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'filter' => CHtml::listData(User::model()->findAll(), 'id', 'username'),
            'value' => '$data->user->username',
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