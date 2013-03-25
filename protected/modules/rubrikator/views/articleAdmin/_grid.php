
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(20),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'date',
            'htmlOptions'=>array('style'=>'width:130px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'title',
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