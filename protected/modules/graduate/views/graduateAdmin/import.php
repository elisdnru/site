<?php
$this->pageTitle='Импорт выпускников';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Выпускники'=>array('index'),
	'Импорт',
);

$this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Классы', 'url'=>$this->createUrl('/graduate/gradeAdmin/index'));

$this->info = 'Выпускники';
?>

<h1>Импорт выпускников</h1>

<?php
/* @var $this DAdminController */
/* @var $model GraduateGrade */
/* @var $form CActiveForm */
?>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'grade-import-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

	<fieldset>
		<div class="row">
			<?php echo $form->labelEx($model, 'grade_id'); ?><br />
			<?php echo $form->dropDownList($model, 'grade_id', array(''=>'') + GraduateGrade::model()->getAssocList()); ?><br />
			<?php echo $form->error($model, 'grade_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'list'); ?><br />
			<?php echo $form->textArea($model, 'list',array('cols'=>40, 'rows'=>20)); ?><br />
			<?php echo $form->error($model, 'list'); ?>
		</div>
	</fieldset>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
