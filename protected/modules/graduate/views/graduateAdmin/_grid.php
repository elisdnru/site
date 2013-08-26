
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'posts-grid',
    'dataProvider'=>$model->search(30),
    'filter'=>$model,
    'columns'=>array(
        array(
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'lastname',
        ),
        array(
            'class'=>'DLinkColumn',
            'name' => 'firstname',
        ),
		array(
			'class'=>'DLinkColumn',
			'name' => 'middlename',
		),
        array(
            'name' => 'year',
            'filter' => GraduateGrade::model()->getYearsList(),
			'value' => '$data->grade ? $data->grade->year : ""',
			'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'name' => 'reward',
            'filter' => GraduateGraduate::model()->getRewardsList(),
			'value' => '$data->rewardName',
			'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'name' => 'number',
            'filter' => GraduateGrade::model()->getNumbersList(),
			'value' => '$data->grade ? $data->grade->number : ""',
			'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'name' => 'letter',
            'filter' => GraduateGrade::model()->getLettersList(),
			'value' => '$data->grade ? $data->grade->letter : ""',
			'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'class'=>'DToggleColumn',
            'name'=>'public',
            'header'=>'О',
            'filter'=>array(1=>'Опубликовано', 0=>'Не опубликовано'),
            'titles'=>array(1=>'Опубликовано', 0=>'Не опубликовано'),
            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
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