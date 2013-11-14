<?php
$this->pageTitle='Редактор';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Интересное'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Книги', 'url'=>$this->createUrl('index'));

$this->info = 'Интересное';
?>

<h1>Добавление элемента</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>