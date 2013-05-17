<?php
/* @var $this DAdminController */
/* @var $model Recipe */
/* @var $form CActiveForm */
?>
<?php $this->widget('tinymce.widgets.TinyMCEWidget'); ?>

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
        <h4>Основное</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'title'); ?><br />
            <?php echo $form->textField($model,'title',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'author'); ?><br />
            <?php echo $form->textField($model,'author',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'author'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'alias'); ?><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'code'); ?><br />
            <?php echo $form->textField($model,'code',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'code'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'free'); ?>
            <?php echo $form->labelEx($model,'free'); ?><br />
            <?php echo $form->error($model,'free'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image): ?>

        <div class="image">
            <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageUrl; ?>" alt="" /></a>
        </div>
        <div class="row">
            <?php echo $form->checkBox($model,'del_image'); ?> <?php echo $form->labelEx($model,'del_image'); ?>
        </div>

        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'image'); ?><br />
            <?php echo $form->fileField($model,'image'); ?><br />
            <?php echo $form->error($model,'image'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model,'short'); ?><br />
            <?php echo $form->textArea($model,'short',array('rows'=>40, 'cols'=>80, 'class'=>'tinymce')); ?>
            <?php echo $form->error($model,'short'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
