<?php
$this->pageTitle='Типы товаров';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
    'Товары'=>array('/shop/productAdmin/index'),
	'Типы товаров',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
$this->admin[] = array('label'=>'Добавить тип', 'url'=>$this->createUrl('create'));

$this->info = 'Для каждого типа можно указать свои категории и атрибуты';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Типы товаров</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>