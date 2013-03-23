<?php
$this->pageTitle='Редактор новостной страницы';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Новости'=>array('/new/newAdmin/index'),
	'Новостные страницы'=>array('index'),
	'Редактор',
);

if ($model->id && $model->page) $this->admin[] = array('label'=>'Просмотр', 'url'=>$model->page->url);
$this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('index'));

$this->info = 'Редактирование шаблона';
?>

<h1>Редактирование новостной страницы</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
