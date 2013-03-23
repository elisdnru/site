<?php
$this->pageTitle = $type->title;
$this->description = $type->description;
$this->keywords = $type->keywords;

$this->breadcrumbs=array(
    $page->title => $this->createUrl('/shop/default/index'),
    $type->title
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index', array('type'=>$type->id)));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Редактировать тип', 'url'=>$this->createUrl('/shop/typeAdmin/update', array('id'=>$type->id)));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/create', array('type'=>$type->id)));

    $this->info = 'Товары типа';
}
?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<h1><?php echo CHtml::encode($type->title); ?></h1>

<div class="subpages">
    <ul>
        <li class="return"><a rel="nofollow" href="<?php echo $this->createUrl('/shop/default/index'); ?>">&larr;</a></li>
        <?php foreach ($categories as $category): ?>
        <li><a href="<?php echo $category->url; ?>"><?php echo $category->title; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
<?php echo $this->decodeWidgets($type->text); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>