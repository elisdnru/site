<?php
$this->pageTitle='Рецепты';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Рецепты',
);

$this->admin[] = array('label'=>'Добавить рецепт', 'url'=>$this->createUrl('create'));
$this->info = 'Рецепты';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Рецепты</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>