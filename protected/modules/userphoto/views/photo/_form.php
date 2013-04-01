<?php
/* @var $this DAdminController */
/* @var $model UserPhoto */
/* @var $form CActiveForm */
?>

<?php $this->beginWidget('DPortlet'); ?>

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

    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'file'); ?><br />
            <?php echo $form->fileField($model,'file', array('size'=>40)); ?>
            <?php echo $form->error($model,'file'); ?>
        </div>

        <br />

        <div class="row">
            <?php echo $form->labelEx($model,'title'); ?><br />
            <?php echo $form->textField($model,'title', array('size'=>80, 'maxlength'=>255)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>
    </fieldset>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?><br />
            <?php echo $form->textArea($model,'text',array('rows'=>10, 'cols'=>80)); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>