<?php
$this->pageTitle='Редактор фотографии';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Фотографии'=>array('index'),
    'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Фотографии', 'url'=>$this->createUrl('index'));

$this->info = 'Фотографии';
?>

<h1>Редактирование фотографии</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
