<?php
$this->pageTitle='Редактор атрибута';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Атрибуты'=>array('index'),
	$model->label
);

$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('index'));

$this->info = 'Редактирование атрибута';
?>

<h1>Редактирование атрибута</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

