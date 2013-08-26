<?php
$this->pageTitle='Редактор статьи';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Рубрикатор'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$model->url);
$this->admin[] = array('label'=>'Статьи', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/rubricator/categoryAdmin/index'));
if ($this->moduleAllowed('newsgallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/newsgallery/galleryAdmin/index'));

$this->info = 'Редактирование статьи';
?>

<h1>Редактирование статьи</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>