<?php
$this->pageTitle='Редактор Фотографии';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Фотографии'=>array('index'),
    'Редактор',
);

$this->admin[] = array('label'=>'Фотографии', 'url'=>$this->createUrl('index'));

$this->info = 'Фотографии';
?>

<h1>Добавление отзыва</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
