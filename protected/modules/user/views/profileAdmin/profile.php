<?php
/* @var $this DAdminController */
/* @var $model Profile */
/* @var $form CActiveForm */

$this->pageTitle='Редактирование профиля пользователя';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Пользователи'=>array('/user/UserAdmin/index'),
	'Редактор профиля',
);

$this->admin[] = array('label'=>'Пользователи', 'url'=>$this->createUrl('admin/users/index'));
if ($model->id) $this->admin[] = array('label'=>'Редактировать логин', 'url'=>$this->createUrl('/user/userAdmin/update', array('id'=>$model->id)));

$this->info = 'Вы можете назначать администраторов';
?>

<?php if (!$model->isNewRecord): ?>
<p class="floatright"><a href="<?php echo $this->createUrl('/user/userAdmin/update', array('id'=>$model->id)); ?>">Редактировать аккаунт</a></p>
<?php endif; ?>

<h1>Редактирование профиля</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>

	<p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>
	
	<fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'lastname'); ?><br />
            <?php echo $form->textField($model,'lastname'); ?>
            <?php echo $form->error($model,'lastname'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?><br />
            <?php echo $form->textField($model,'name'); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'middlename'); ?><br />
            <?php echo $form->textField($model,'middlename'); ?>
            <?php echo $form->error($model,'middlename'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'phone'); ?><br />
            <?php echo $form->textField($model,'phone', array('size'=>40, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'phone'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'address'); ?><br />
            <?php echo $form->textArea($model,'address', array('cols'=>60, 'rows'=>3, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'address'); ?>
        </div>
		
	</fieldset>

	<fieldset>
    <div class="row">

        <p><img src="<?php echo $model->avataruRL; ?>" alt="" /></p>

        <br /><?php echo $form->labelEx($model,'avatar'); ?><br />
        <?php echo $form->fileField($model, 'avatar'); ?>
        <?php echo $form->error($model,'avatar'); ?>
    </div>
    </fieldset>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
