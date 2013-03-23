<?php
$this->pageTitle = $page->pagetitle . ' - Поиск';
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title => $this->createUrl('/shop'),
    'Поиск',
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Редактировать товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/create'));

    $this->info = 'Поиск';
}
?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<h1><?php echo CHtml::encode($page->title); ?> - Поиск</h1>

<?php $this->beginWidget('DPortlet', array('title' => null));?>
<?php $this->widget('shop.widgets.ShopSearchFormWidget');?>
<?php $this->endWidget();?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>



