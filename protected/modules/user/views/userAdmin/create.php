<?php
/* @var $this DAdminController */
/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle='Пользователи';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Пользователи'=>array('index'),
    'Редактор',
);

$this->admin[] = array('label'=>'Пользователи', 'url'=>$this->createUrl('index'));

$this->info = 'Для добавления администратора выберите соответствующую роль';
?>

<h1>Добавление пользователя</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>