<?php
$this->pageTitle='Редактор выпускного класса';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Выпускники'=>array('/graduate/graduateAdmin/index'),
	'Классы'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('/graduate/graduateAdmin/index'));

$this->info = 'Выпускные классы';
?>

<h1>Добавление выпускного класса</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>