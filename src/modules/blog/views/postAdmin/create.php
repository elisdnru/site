<?php
/* @var $this DAdminController */
/* @var $model BlogPost */

Yii::import('application.modules.gallery.models.*');

$this->pageTitle='Редактор записи блога';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Записи блога'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Все записи', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/blog/categoryAdmin/index'));
$this->admin[] = array('label'=>'Метки', 'url'=>$this->createUrl('/blog/tagAdmin/index'));
if ($this->moduleAllowed('newsgallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/newsgallery/galleryAdmin/index'));

?>

<h1>Добавление записи</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>


