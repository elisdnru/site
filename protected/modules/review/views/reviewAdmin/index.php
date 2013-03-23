<?php
$this->pageTitle='Отзывы';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Отзывы',
);

$this->admin[] = array('label'=>'Добавить отзыв', 'url'=>$this->createUrl('create'));
$this->info = 'Рецепты';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Отзывы</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>