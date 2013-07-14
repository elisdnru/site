<?php
$this->pageTitle='Сотрудники';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Сотрудники',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/personnel/categoryAdmin/index'));
$this->admin[] = array('label'=>'Добавить сотрудника', 'url'=>$this->createUrl('create'));
$this->info = 'Сотрудники';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Сотрудники</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>