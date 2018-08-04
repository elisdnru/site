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
$this->admin[] = array('label'=>'Управление фотографиями', 'url'=>$this->createUrl('files', array('id'=>$model->id)));

$this->info = 'Фотогалереи';
?>

<h1>Редактирование фотогалереи</h1>

<p><a href="<?php echo $this->createUrl('files', array('id'=>$model->id)); ?>">Управление фотографиями</a></p>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>