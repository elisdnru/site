<?php
/* @var $this DAdminController */
/* @var $model BlogTag */

$this->pageTitle='Редактор метки блога';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Блоги'=>array('/blog/postAdmin'),
	'Метки'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Метки', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin/index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/blog/categoryAdmin/index'));
$this->admin[] = array('label'=>'Группы', 'url'=>$this->createUrl('/blog/groupAdmin/index'));
$this->info = '<p>Метки блога</p>';

?>

<h1>Редактирование метки блога</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
