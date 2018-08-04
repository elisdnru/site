<?php
/* @var $this DAdminController */
/* @var $model GalleryCategory */

$this->pageTitle='Редактор категории галереи';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Фото и видео'=>array('/gallery/photoAdmin'),
	'Категории'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Материалы', 'url'=>$this->createUrl('/gallery/photoAdmin/index'));
$this->info = '<p>Категории галереи</p>';

?>

<h1>Редактирование категории галереи</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
