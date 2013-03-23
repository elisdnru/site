<?php
$this->pageTitle='Слайды';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Слайды',
);

$this->admin[] = array('label'=>'Добавить слайд', 'url'=>$this->createUrl('create'));
$this->info = 'Слайды';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Слайды</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>