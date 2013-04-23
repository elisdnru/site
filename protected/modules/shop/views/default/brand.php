<?php
$this->pageTitle = $brand->title;
$this->description = $brand->description;
$this->keywords = $brand->keywords;

$this->breadcrumbs=array(
    $page->title => $this->createUrl('/shop/default/index'),
);

if ($type || $category)
{
    $this->breadcrumbs = array_merge($this->breadcrumbs, array(
        $brand->title => $brand->url,
    ));

    if ($type)
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            $type->title => $type->url,
        ));

    if ($category)
        $this->breadcrumbs = array_merge($this->breadcrumbs, $category->getBreadcrumbs(true));
}
else
{
    $this->breadcrumbs[] = $brand->title;
}

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index', array('ShopProduct[brand_id]'=>$brand->id)));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Редактировать тип', 'url'=>$this->createUrl('/shop/typeAdmin/update', array('id'=>$brand->id)));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/create'));

    $this->info = 'Товары производителя';
}
?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<h1><?php echo CHtml::encode($brand->title); ?></h1>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
<?php echo $this->decodeWidgets($brand->text); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>