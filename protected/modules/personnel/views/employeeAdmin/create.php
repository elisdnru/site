<?php
$this->pageTitle='Редактор сотрудника';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Сотрудники'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Сотрудники', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/personnel/categoryAdmin/index'));

$this->info = 'Сотрудники';
?>

<h1>Добавление сотрудника</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>