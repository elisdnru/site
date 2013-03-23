<?php
/* @var $this DAdminController */
/* @var $model Menu */

$this->pageTitle='Редактор меню';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Меню'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Пункты меню', 'url'=>$this->createUrl('index'));
if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Создать страницу', 'url'=>$this->createUrl('admin/pages/update'));

$this->info = 'Псевдонимы используются системой для вывода соответствующих меню в шаблоне';
?>

<h1>Добавление пункта меню</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

