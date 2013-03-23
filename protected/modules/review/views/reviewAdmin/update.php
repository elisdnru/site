<?php
$this->pageTitle='Редактор отзыва';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Отзывы'=>array('index'),
    'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Отзывы', 'url'=>$this->createUrl('index'));

$this->info = 'Отзывы';
?>

<h1>Редактирование отзыва</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
