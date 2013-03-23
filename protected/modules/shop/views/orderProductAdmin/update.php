<?php
/* @var $this DAdminController */
/* @var $model ShopOrderProduct */

$this->pageTitle='Заказ';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Заказы'=>array('/shop/orderAdmin/index'),
    'Заказ ' . $model->order->fullId =>$this->createUrl('/shop/orderAdmin/view', array('id'=>$model->order_id)),
    'Редактирование элемента'
);

$this->admin[] = array('label'=>'Заказы', 'url'=>$this->createUrl('/shop/orderAdmin/index'));
$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('/shop/orderAdmin/view', array('id'=>$model->order_id)));

$this->info = 'Редактирование элемента заказа';
?>

<h1>Редактирование элемента заказа</h1>

<?php
/* @var $this DAdminController */
/* @var $model ShopOrderProduct */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', 
	array(
		'id'=>'new-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions'=>array('enctype'=>'multipart/form-data')
	)
); ?>

	<p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

	<fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'artikul'); ?><br />
            <?php echo $form->textField($model,'artikul',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'artikul'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'count'); ?><br />
            <?php echo $form->textField($model,'count',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'count'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'comment'); ?><br />
            <?php echo $form->textField($model,'comment',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'comment'); ?>
        </div>
	</fieldset>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
