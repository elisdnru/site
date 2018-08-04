<?php
$this->pageTitle='Редактор шаблона';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Страницы'=>array('/page/pageAdmin/index'),
	'Шаблоны'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Шаблоны', 'url'=>$this->createUrl('index'));
if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Страницы', 'url'=>$this->createUrl('/page/pageAdmin/index'));

$this->info = 'После создания страницы Вы можете привязать её к любому пункту меню';

?>

<h1>Редактирование шаблона</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

