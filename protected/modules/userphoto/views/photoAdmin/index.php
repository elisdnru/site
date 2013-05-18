<?php
$this->pageTitle='Фотографии';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Фотографии',
);

$this->admin[] = array('label'=>'Добавить отзыв', 'url'=>$this->createUrl('create'));
$this->info = 'Фотографии';
?>

<h1>Фотографии</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>