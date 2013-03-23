<?php
$this->pageTitle='Заказы';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Заказы',
);

$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));

$this->info = 'Срочные невыполненные заказы подсвечены';
?>

<h1>Заказы</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>