<?php
$this->pageTitle='Редактор товара';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('index'),
	'Добавление товара'
);

$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('index'));
$this->info = 'Редактирование товара';
?>

<h1>Добавление товара</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

