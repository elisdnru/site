<?php
$this->pageTitle='Производители товаров';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
    'Товары'=>array('/shop/productAdmin/index'),
	'Производители товаров',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
$this->admin[] = array('label'=>'Добавить производителя', 'url'=>$this->createUrl('create'));

$this->info = 'Производители';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Производители товаров</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>