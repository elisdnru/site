
<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(50),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class' => 'DImageLinkColumn',
            'value' => '$data->getAvatarUrl(50, 50)',
            'width' => 50,
            'htmlOptions'=>array('style'=>'width:32px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'username',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'email',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'fio',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'name' => 'role',
            'value' => 'Access::getRoleName($data->role)',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'filter' => Access::getRoles(),
        ),
        array(
            'name' => 'create_datetime',
            'header'=>'Дата регистрации',
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
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