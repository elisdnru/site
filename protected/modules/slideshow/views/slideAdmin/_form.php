<?php
/* @var $this DAdminController */
/* @var $model Slide */
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
        <h4>Содержимое</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'title'); ?><br />
            <?php echo $form->textArea($model,'title',array('rows'=>3, 'cols'=>80)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?><br />
            <?php echo $form->textArea($model,'text',array('rows'=>3, 'cols'=>80)); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Ссылка</h4>

        <div class="row">
            <?php echo $form->labelEx($model,'url'); ?><br />
            <?php echo $form->textField($model,'url',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'url'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image): ?>

        <div class="image">
            <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt="" /></a>
        </div>

        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'image'); ?><br />
            <?php echo $form->fileField($model,'image'); ?><br />
            <?php echo $form->error($model,'image'); ?>
        </div>

    </fieldset>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
