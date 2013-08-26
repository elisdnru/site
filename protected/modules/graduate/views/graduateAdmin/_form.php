<?php
/* @var $this DAdminController */
/* @var $model GraduateGraduate */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm',
    array(
        'id'=>'graduate-form',
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
        <h4>Основное</h4>

		<div class="row">
			<?php echo $form->labelEx($model, 'lastname'); ?><br />
			<?php echo $form->textField($model, 'lastname',array('size'=>60, 'maxlength'=>255)); ?><br />
			<?php echo $form->error($model, 'lastname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'firstname'); ?><br />
			<?php echo $form->textField($model, 'firstname',array('size'=>60, 'maxlength'=>255)); ?><br />
			<?php echo $form->error($model, 'firstname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'middlename'); ?><br />
			<?php echo $form->textField($model, 'middlename',array('size'=>60, 'maxlength'=>255)); ?><br />
			<?php echo $form->error($model, 'middlename'); ?>
		</div>

        <div class="row">
            <?php echo $form->labelEx($model, 'grade_id'); ?><br />
            <?php echo $form->dropDownList($model, 'grade_id', GraduateGrade::model()->getAssocList()); ?><br />
            <?php echo $form->error($model, 'grade_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'reward'); ?><br />
            <?php echo $form->dropDownList($model, 'reward', array(0=>'') + GraduateGraduate::model()->getRewardsList()); ?><br />
            <?php echo $form->error($model, 'reward'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model, 'public'); ?>
            <?php echo $form->labelEx($model, 'public'); ?><br />
            <?php echo $form->error($model, 'public'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
