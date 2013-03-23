<?php
$this->pageTitle='Редактор слайда';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Слайды'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Слайды', 'url'=>$this->createUrl('index'));

$this->info = 'Слайды';
?>

<h1>Добавление слайда</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>