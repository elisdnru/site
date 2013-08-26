<?php
$this->pageTitle='Редактор выпускника';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Выпускники'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$model->url);
$this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Классы', 'url'=>$this->createUrl('/graduate/gradeAdmin/index'));

$this->info = 'Выпускники';
?>

<h1>Редактирование выпускника</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>