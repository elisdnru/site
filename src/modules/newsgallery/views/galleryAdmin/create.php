<?php
/* @var $this DAdminController */
/* @var $model NewsGallery */

$this->pageTitle='Редактор фотогалереи';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Фотогалереи'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Фотогалереи', 'url'=>$this->createUrl('index'));

$this->info = 'Фотогалереи';
?>

<h1>Добавление фотогалереи</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>