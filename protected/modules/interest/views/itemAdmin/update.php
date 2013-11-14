<?php
$this->pageTitle='Редактор';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Интересное'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Интересное', 'url'=>$this->createUrl('index'));

$this->info = 'Интересное';
?>

<h1>Редактирование элемента</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>