<?php
$this->pageTitle='Редактор категории сотрудников';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Сотрудники'=>array('/personnel/employeeAdmin/index'),
	'Категории'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Сотрудники', 'url'=>$this->createUrl('/personnel/employeeAdmin/index'));

$this->info = 'Категории сотрудников';
?>

<h1>Редактирование категории сотрудников</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>