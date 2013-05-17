<?php
$this->pageTitle='Редактор книги';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Книги'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Книги', 'url'=>$this->createUrl('index'));

$this->info = 'Книги';
?>

<h1>Добавление книги</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>