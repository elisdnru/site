<?php
$this->pageTitle='Редактор выпускника';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Выпускники'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Классы', 'url'=>$this->createUrl('/graduate/gradeAdmin/index'));
$this->admin[] = array('label'=>'Импорт выпускников', 'url'=>$this->createUrl('importList'));

$this->info = 'Выпускники';
?>

<h1>Добавление выпускника</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>