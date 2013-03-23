<?php
$this->pageTitle='Редактор размера';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Размеры товаров'=>array('index'),
	'Добавление размера'
);

$this->admin[] = array('label'=>'Размеры', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));

$this->info = 'Добавление размера';
?>

<h1>Добавление размера</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

