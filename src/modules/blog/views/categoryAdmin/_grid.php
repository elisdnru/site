
<?php $this->widget('zii.widgets.grid.CGridView', array(
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
            'name'=>'alias',
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{view}',
            'viewButtonUrl'=>'$data->url',
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