<?php
$this->pageTitle='Заказ';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Заказы'=>array('index'),
    'Заказ ' . $model->fullId =>$this->createUrl('/shop/orderAdmin/view', array('id'=>$model->id)),
    'Редактирование'
);

$this->admin[] = array('label'=>'Заказы', 'url'=>$this->createUrl('/shop/orderAdmin/index'));
$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('/shop/orderAdmin/view', array('id'=>$model->id)));
//$this->admin[] = array('label'=>'Содержимое', 'url'=>$this->createUrl('/shop/orderProductAdmin/index', array('id'=>$model->id)));

$this->info = 'Редактирование заказа';
?>

<h1>Редактирование заказа</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>