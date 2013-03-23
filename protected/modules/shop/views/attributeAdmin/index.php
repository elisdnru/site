<?php
$this->pageTitle='Атрибуты товаров';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
    'Товары'=>array('/shop/productAdmin/index'),
	'Атрибуты товаров',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Типы товаров', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
$this->admin[] = array('label'=>'Добавить атрибут', 'url'=>$this->createUrl('create'));

$this->info = '';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Атрибуты товаров</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>