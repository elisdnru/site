<?php
$this->pageTitle='Редактор новостной страницы';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Новости'=>array('index'),
	'Редактор новостной страницы',
);

$this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('index'));
if ($this->moduleAllowed('newsgallery')) if ($model->id) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/newsgallery/galleryAdmin/index'));

$this->info = 'Выберите из существующих страниц';
?>

<h1>Добавление новостной страницы</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
