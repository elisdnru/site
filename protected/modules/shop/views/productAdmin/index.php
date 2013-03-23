<?php
$this->pageTitle='Товары';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('create'));

$this->info = 'Вы можете переключать значения флага публикации щёлкая непосредственно по нему';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить товар</a></p>

<h1>Товары</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
