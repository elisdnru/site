<?php
$this->pageTitle='Редактор атрибута';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Атрибуты'=>array('index'),
	'Добавление атрибута'
);

$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('index'));

$this->info = 'Добавление атрибута';
?>

<h1>Добавление атрибута</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

