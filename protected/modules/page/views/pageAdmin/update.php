<?php
$this->pageTitle='Редактор страниц';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Страницы'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Cтраницы', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Просмотр', 'url'=>$model->url);
if ($this->moduleAllowed('menu')) $this->admin[] = array('label'=>'Пункты меню', 'url'=>$this->createUrl('/menu/menuAdmin/index'));
if ($this->moduleAllowed('new')) $this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('/new/newAdmin/index'));

$this->info = 'После создания страницы Вы можете привязать её к любому пункту меню';

?>

<h1>Редактирование страницы</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

