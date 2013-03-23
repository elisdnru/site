<?php
$this->pageTitle='Редактор рецепта';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Рецепты'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Рецепты', 'url'=>$this->createUrl('index'));
if ($this->moduleAllowed('gallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/gallery/galleryAdmin/index'));

$this->info = 'Рецепты';
?>

<h1>Добавление рецепта</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>