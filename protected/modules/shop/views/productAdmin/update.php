<?php
$this->pageTitle='Редактор товара';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('index'),
	$model->title
);

$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Модели товара', 'url'=>$this->createUrl('/shop/modelAdmin/index', array('ShopModel[product_id]'=>$model->id)));
if ($model->public) $this->admin[] = array('label'=>'Просмотр', 'url'=>$model->url);
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));
$this->admin[] = array('label'=>'Типы', 'url'=>$this->createUrl('/shop/typeAdmin/index'));
$this->admin[] = array('label'=>'Атрибуты', 'url'=>$this->createUrl('/shop/attributeAdmin/index'));
$this->info = 'Редактирование товара';
?>

<h1>Редактирование товара</h1>

<?php $this->renderPartial('_related', array('model'=>$model)); ?>

<div style="float:right">
    <?php echo CHtml::beginForm($this->createUrl('create', array('id'=>$model->id)), 'get'); ?>
    <div class="form">
        <div class="row buttons">
            <?php echo CHtml::submitButton('Клонировать'); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

