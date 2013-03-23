<?php
$this->pageTitle='Редактор работы';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Портфолио'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$model->url);
$this->admin[] = array('label'=>'Работы', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/portfolio/categoryAdmin/index'));

$this->info = 'Портфолио';
?>

<h1>Редактирование работы</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>