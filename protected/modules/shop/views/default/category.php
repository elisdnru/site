<?php
$this->pageTitle = $category->getFullTitle();
$this->description = $category->description;
$this->keywords = $category->keywords;

$this->breadcrumbs=array(
    $page->title => $this->createUrl('/shop/default/index'),
    $category->type->title => $this->createUrl('/shop/default/type', array('type'=>$category->type->alias))
);
$this->breadcrumbs = array_merge($this->breadcrumbs, $category->breadcrumbs);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index', array('category'=>$category->id)));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Редактировать категорию', 'url'=>$this->createUrl('/shop/categoryAdmin/update', array('id'=>$category->id)));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/create', array('category'=>$category->id)));

    $this->info = 'Товары категории';
}
?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<h1><?php echo CHtml::encode($category->title); ?></h1>

<div class="subpages">
    <ul>
        <li class="return"><a rel="nofollow" href="<?php echo $category->parent ? $category->parent->url : $this->createUrl('/shop/default/index'); ?>">&larr;</a></li>
        <?php foreach ($subcategories as $subcategory): ?>
        <li><a href="<?php echo $subcategory->url; ?>"><?php echo $subcategory->title; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
<?php echo $this->decodeWidgets($category->text); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>