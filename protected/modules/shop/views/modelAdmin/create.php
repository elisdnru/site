<?php
$this->pageTitle='Редактор модели товара';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Модели товара'=>$this->createUrl('index', array('ShopModel[product_id]'=>$model->product_id)),
	'Добавление модели'
);

$this->admin[] = array('label'=>'Модели', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));

$this->info = 'Добавление модели товара';
?>

<h1>Добавление модели товара</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

