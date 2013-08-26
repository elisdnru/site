<?php
/* @var $this DAdminController */
/* @var $model GraduateGrade */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'grade-form',
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
            <?php echo $form->labelEx($model, 'year'); ?><br />
            <?php echo $form->textField($model, 'year',array('size'=>4, 'maxlength'=>4)); ?><br />
            <?php echo $form->error($model, 'year'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'number'); ?><br />
            <?php echo $form->dropDownList($model, 'number', GraduateGrade::model()->getNumbersList()); ?><br />
            <?php echo $form->error($model, 'number'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'letter'); ?><br />
            <?php echo $form->dropDownList($model, 'letter', GraduateGrade::model()->getLettersList()); ?><br />
            <?php echo $form->error($model, 'letter'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'teacher'); ?><br />
            <?php echo $form->textField($model, 'teacher',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model, 'teacher'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
