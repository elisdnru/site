<?php
$this->pageTitle='Редактор цвета';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Цвета'=>array('index'),
	$model->title
);

$this->admin[] = array('label'=>'Цвета', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));

$this->info = 'Редактирование цвета';
?>

<h1>Редактирование цвета</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

