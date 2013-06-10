
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(

		array(
			'class'=>'DImageLinkColumn',
			'value' => '$data->getImageThumbUrl()',
			'width' => 250,
			'htmlOptions'=>array('style'=>'width:250px;text-align:center'),
		),
        array(
            'name'=>'sort',
            'htmlOptions'=>array('style'=>'width:50px;text-align:center'),
        ),
		array(
			'class'=>'DLinkColumn',
			'name' => 'title',
		),
		array(
			'class'=>'DLinkColumn',
			'name' => 'url',
			'htmlOptions'=>array('style'=>'text-align:center'),
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