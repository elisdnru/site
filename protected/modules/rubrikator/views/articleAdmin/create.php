<?php
$this->pageTitle='Редактор статьи';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Рубрикатор'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Статьи', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/rubrikator/categoryAdmin/index'));
if ($this->moduleAllowed('gallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/gallery/galleryAdmin/index'));

$this->info = 'Редактор статьи';
?>

<h1>Добавление статьи</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>