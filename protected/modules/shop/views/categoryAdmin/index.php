<?php
$this->pageTitle='Категории товаров';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('/shop/productAdmin/index'),
	'Категории товаров',
);

$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
$this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
$this->admin[] = array('label'=>'Добавить категорию', 'url'=>$this->createUrl('create'));

$this->info = 'Категории товаров';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории товаров</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>