<?php
$this->pageTitle='Динамические атрибуты';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Атрибуты',
);

$this->admin[] = array('label'=>'Добавить атрибут', 'url'=>$this->createUrl('create'));

$this->info = 'Вы можете переключать значения флага публикации щёлкая непосредственно по нему';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Динамические атрибуты</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>