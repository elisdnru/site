<?php
$this->pageTitle='Редактор категории товаров';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Категории товаров'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('index'));

$this->info = '<p>Категории товаров</p>';
?>

<h1>Добавление категории товаров</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
