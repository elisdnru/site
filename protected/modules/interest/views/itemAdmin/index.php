<?php
$this->pageTitle='Интересное';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Интересное',
);

$this->admin[] = array('label'=>'Добавить элемент', 'url'=>$this->createUrl('create'));
$this->info = 'Интересное';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Интересное</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>