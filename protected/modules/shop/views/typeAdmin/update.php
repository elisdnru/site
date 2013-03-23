<?php
$this->pageTitle='Редактор типа';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Типы'=>array('index'),
	$model->title
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$model->url);
$this->admin[] = array('label'=>'Типы товаров', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));

$this->info = 'Редактирование типа';
?>

<h1>Редактирование типа товаров</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

