<?php
$this->pageTitle='Категории сотрудников';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Сотрудники'=>array('/personnel/employeeAdmin/index'),
	'Категории',
);
$this->admin[] = array('label'=>'Сотрудники', 'url'=>$this->createUrl('/personnel/employeeAdmin/index'));
$this->admin[] = array('label'=>'Добавить категорию', 'url'=>$this->createUrl('create'));

$this->info = 'Категории сотрудников';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории сотрудников</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>