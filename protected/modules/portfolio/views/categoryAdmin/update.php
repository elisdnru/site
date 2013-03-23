<?php
$this->pageTitle='Редактор категории портфолио';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Портфолио'=>array('/portfolio/workAdmin/index'),
	'Категории'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Работы', 'url'=>$this->createUrl('/portfolio/workAdmin/index'));

$this->info = 'Категории портфолио';
?>

<h1>Редактирование категории портфолио</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>