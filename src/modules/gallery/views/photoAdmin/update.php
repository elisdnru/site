<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */

Yii::import('application.modules.gallery.models.*');

$this->pageTitle='Редактор фото или видео';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Фото или видео'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Все материалы', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/gallery/categoryAdmin/index'));
$this->admin[] = array('label'=>'Править категорию', 'url'=>$this->createUrl('/gallery/categoryAdmin/update', array('id'=>$model->category_id)));
?>

<h1>Редактирование фото или видео</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>


