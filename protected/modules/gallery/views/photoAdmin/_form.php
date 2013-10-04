<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */
/* @var $form CActiveForm */
?>

<?php $this->widget('tinymce.widgets.TinyMCEWidget'); ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm',
    array(
        'id'=>'gallery-photo-form',
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
            <?php echo $form->textField($model, 'title', array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model, 'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'category_id'); ?><br />
            <?php echo $form->dropDownList($model,'category_id',array(''=>'') + GalleryCategory::model()->getTabList()); ?><br />
            <?php echo $form->error($model,'category_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'date'); ?><br />
            <?php echo $form->textField($model,'date',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'date'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'public'); ?>
            <?php echo $form->labelEx($model,'public'); ?><br />
            <?php echo $form->error($model,'public'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image): ?>

        <div class="image">
            <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt="" /></a>
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
        <div class="row">
            <?php echo $form->labelEx($model,'video'); ?><br />
            <?php echo $form->textField($model,'video'); ?><br />
            <?php echo $form->error($model,'video'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'image_alt'); ?><br />
            <?php echo $form->textField($model,'image_alt',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'image_alt'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?><br />
            <?php echo $form->textArea($model,'text',array('rows'=>40, 'cols'=>80, 'class'=>'tinymce')); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </fieldset>

    <?php echo $this->renderPartial('//common/forms/_meta', array(
        'form'=>$form,
        'model'=>$model,
    )); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->