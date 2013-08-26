
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'DLinkColumn',
            'name'=>'year',
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'number',
			'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'letter',
			'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DLinkColumn',
            'name'=>'teacher',
        ),
        array(
			'class'=>'DLinkColumn',
            'header'=>'Выпускники',
            'value'=>'$data->graduates_count',
            'link'=>'Yii::app()->controller->createUrl("graduateAdmin/index", array(
            	"GraduateGraduate[year]"=>$data->year,
            	"GraduateGraduate[number]"=>$data->number,
            	"GraduateGraduate[letter]"=>$data->letter,
			))',
			'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{update}',
        ),
        array(
            'class'=>'DButtonColumn',
            'template'=>'{delete}',
			'deleteConfirmation'=>'При удалении класса удаляются и его выпускники. Удалить класс?'
        ),
    ),
)); ?>