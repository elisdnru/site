<?php
$this->pageTitle='Редактор модели';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Модели товара'=>$this->createUrl('index', array('ShopModel[product_id]'=>$model->product_id)),
	$model->title
);

$this->admin[] = array('label'=>'Модели товара', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));

$this->info = 'Редактирование модели';
?>

<h1>Редактирование модели товара</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

