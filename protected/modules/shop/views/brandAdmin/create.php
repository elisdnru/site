<?php
$this->pageTitle='Добавление производителя';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Производители'=>array('index'),
	'Добавление производителя'
);

$this->admin[] = array('label'=>'Производители', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));

$this->info = 'Добавление производителя товаров';
?>

<h1>Добавление производителя</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

