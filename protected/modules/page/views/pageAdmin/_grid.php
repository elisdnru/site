
<?php $this->widget('DGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DIndentLinkColumn',
            'name'=>'alias',
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'title',
        ),
        array(
            'class'=>'DButtonColumn',
            'htmlOptions'=>array('style'=>'width:20px;text-align:center'),
            'template'=>'{view}',
            'viewButtonUrl'=>'$data->url',
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