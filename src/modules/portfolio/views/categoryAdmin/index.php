<?php
$this->pageTitle='Категории портфолио';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Портфолио'=>array('/portfolio/workAdmin/index'),
	'Категории',
);
$this->admin[] = array('label'=>'Работы', 'url'=>$this->createUrl('/portfolio/workAdmin/index'));
$this->admin[] = array('label'=>'Добавить категорию', 'url'=>$this->createUrl('create'));

$this->info = 'Категории работ';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории работ</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>