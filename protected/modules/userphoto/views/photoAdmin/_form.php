<?php
/* @var $this DAdminController */
/* @var $model Review */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm',
    array(
        'id'=>'review-form',
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
            <?php echo $form->labelEx($model,'title'); ?><br />
            <?php echo $form->textField($model,'title',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'title'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->file): ?>
            <div class="image">
                <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt="" /></a>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'file'); ?><br />
            <?php echo $form->fileField($model,'file'); ?><br />
            <?php echo $form->error($model,'file'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?><br />
            <?php echo $form->textArea($model,'text',array('rows'=>20, 'cols'=>80)); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->