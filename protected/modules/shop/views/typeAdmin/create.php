<?php
$this->pageTitle='Редактор типа товара';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Типы товаров'=>array('index'),
	'Добавление типа'
);

$this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));

$this->info = 'Добавление типа товаров';
?>

<h1>Добавление типа товаров</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

