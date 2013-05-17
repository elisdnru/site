<?php
$this->pageTitle='Редактор книги';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Книги'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Книги', 'url'=>$this->createUrl('index'));

$this->info = 'Книги';
?>

<h1>Редактирование книги</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>