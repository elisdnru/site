<?php
$this->pageTitle='Редактор выпускного класса';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Выпускники'=>array('/graduate/graduateAdmin/index'),
	'Классы'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Классы', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('/graduate/graduateAdmin/index'));

$this->info = 'Выпускние классы';
?>

<h1>Редактирование выпускного класса</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>