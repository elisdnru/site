<?php

$keywords = array();

if ($model->category) $keywords[] = CHtml::encode($model->category->title);

$this->pageTitle = $model->title;
$this->description = $model->description ? $model->description : CHtml::encode(strip_tags($model->text));
$this->keywords = $model->keywords ? $model->keywords : implode(', ', $keywords);
$this->breadcrumbs=array(
    $page->title => $this->createUrl('/shop'),
    $model->type->title => $model->type->url,
);
if ($model->category)
    $this->breadcrumbs = array_merge($this->breadcrumbs, $model->category->getBreadcrumbs(true));

$this->breadcrumbs[]= $model->title;

if ($this->is(Access::ROLE_CONTROL)){

    $this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
    $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/shop/productAdmin/update', array('id'=>$model->id)));
    $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/create'));

	$this->info = 'Управлять товаром Вы можете перейдя по соответствующим ссылкам';
}?>

<?php if (Yii::app()->config->get('SHOP.GROUP_BY_TITLE') && count($model->related_products) > 1): ?>
    <?php $this->renderPartial('_group', array('model'=>$model)); ?>
<?php else: ?>
    <?php $this->renderPartial('_single', array('model'=>$model)); ?>
<?php endif; ?>


