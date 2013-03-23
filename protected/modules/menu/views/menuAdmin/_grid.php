
<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'sort',
            'htmlOptions'=>array('style'=>'width:50px;text-align:center'),
        ),
        array(
            'class'=>'DIndentLinkColumn',
            'name'=>'title',
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'link',
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'alias',
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'visible',
            'header'=>'В',
            'filter'=>array(1=>'Видимые', 0=>'Скрытые'),
            'titles'=>array(1=>'Видимо', 0=>'Скрыто'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{view}',
            'viewButtonUrl'=>'$data->link',
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