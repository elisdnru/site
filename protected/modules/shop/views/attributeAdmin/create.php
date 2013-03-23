<?php
$this->pageTitle='Редактор атрибута';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Атрибуты'=>array('index'),
	'Добавление атрибута'
);

$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));

$this->info = 'Добавление атрибута';
?>

<h1>Добавление атрибута</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

