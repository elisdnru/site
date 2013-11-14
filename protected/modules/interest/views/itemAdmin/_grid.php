<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'books-grid',
    'dataProvider'=>$model->search(20),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DImageLinkColumn',
            'value' => '$data->getImageUrl()',
            'width' => 150,
            'height' => 211,
            'htmlOptions'=>array('style'=>'width:150px;text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'title',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'author',
            'htmlOptions'=>array('style'=>'text-align:center'),
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