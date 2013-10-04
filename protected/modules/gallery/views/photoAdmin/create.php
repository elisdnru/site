<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */

Yii::import('application.modules.gallery.models.*');

$this->pageTitle='Редактор материала галереи';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Фото и видео'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Фото и видео', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/gallery/categoryAdmin/index'));

?>

<h1>Добавление фото или видео</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>


