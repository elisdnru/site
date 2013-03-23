<?php
/* @var $this DAdminController */
/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle='Редактирование данных пользователя';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Пользователи'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Пользователи', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));

$this->info = 'Вы можете назначать администраторов';
?>

<h1>Редактирование пользователя</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<hr />

<?php $this->renderPartial('_access', array('model'=>$model)); ?>




