<?php $this->reflash() ?>
<?php $this->redirect($this->createUrl('index', array(
	'GraduateGraduate[year]' => $model->grade ? $model->grade->year : '',
	'GraduateGraduate[number]' => $model->grade ? $model->grade->number : '',
	'GraduateGraduate[letter]' => $model->grade ? $model->grade->letter : '',
))); ?>