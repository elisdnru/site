<?php
/* @var $this DAdminController */
/* @var $model BlogCategory */

$this->pageTitle='Редактор категории блога';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Блоги'=>array('/blog/postAdmin'),
	'Категории'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin/index'));
$this->admin[] = array('label'=>'Группы', 'url'=>$this->createUrl('/blog/groupAdmin/index'));
$this->info = '<p>Категории блога</p>';

?>

<h1>Редактирование категории блога</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
