<?php
$this->pageTitle='Редактор страниц';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
    'Страницы'=>array('/page/pageAdmin/index'),
	'Шаблоны'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Шаблоны', 'url'=>$this->createUrl('index'));
if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Страницы', 'url'=>$this->createUrl('/new/pageAdmin/index'));

$this->info = 'Шаблоны';
?>

<h1>Добавление шаблона</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

