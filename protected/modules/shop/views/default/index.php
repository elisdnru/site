<?php
$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));
    if ($this->moduleAllowed('page')) if ($page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/create'));

}

$this->info = 'Здесь собраны товары из всех разделов';
?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<div class="subpages">
    <?php $this->widget('zii.widgets.CMenu',array(
        'items'=>ShopType::model()->cache(0, new Tags('shop'))->getMenuList())
    ); ?>
    <div class="clear"></div>
</div>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
<?php echo $this->decodeWidgets($page->text_purified); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>




