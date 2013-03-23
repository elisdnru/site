<?php
$this->pageTitle='Редактор типа';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Типы'=>array('index'),
	'Добавление типа'
);

$this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));

$this->info = 'Добавление типа товаров';
?>

<h1>Добавление типа</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

