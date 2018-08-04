<?php
$this->pageTitle='Редактор блоков';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Блоки'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Блоки', 'url'=>$this->createUrl('index'));
$this->info = 'Блоки';

?>

<h1>Добавление блока</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
