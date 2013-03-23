<?php
$this->pageTitle='Модули';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Модули',
);

$this->admin[] = array('label'=>'Вернуться на сайт', 'url'=>'/index');
$this->info = 'Здесь Вы можете управлять содержимым сайта и сообщениями';

?>
<h1>Модули</h1>

<?php $this->renderPartial('_grid', array('dataProvider'=>$dataProvider)); ?>