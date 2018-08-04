
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DLinkColumn',
            'name'=>'title',
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'frequency',
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
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