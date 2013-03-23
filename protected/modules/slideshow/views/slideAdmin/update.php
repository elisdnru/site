<?php
$this->pageTitle='Редактор слайда';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Слайды'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Слайды', 'url'=>$this->createUrl('index'));

$this->info = 'Слайды';
?>

<h1>Редактирование слайда</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>