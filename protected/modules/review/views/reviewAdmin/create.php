<?php
$this->pageTitle='Редактор отзыва';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Отзывы'=>array('index'),
    'Редактор',
);

$this->admin[] = array('label'=>'Отзывы', 'url'=>$this->createUrl('index'));

$this->info = 'Отзывы';
?>

<h1>Добавление отзыва</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
