<?php
/* @var $this DAdminController */
/* @var $model GalleryCategory */
/* @var $form CActiveForm */
?>

<?php $this->widget('tinymce.widgets.TinyMCEWidget'); ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'page-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model, 'title'); ?><br/>
            <?php echo $form->textField($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br/>
            <?php echo $form->error($model, 'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'alias'); ?>
            &nbsp;<a href="javascript:transliterate('GalleryCategory_title', 'GalleryCategory_alias')">Транслит
                наименования</a><br/>
            <?php echo $form->textField($model, 'alias', ['size' => 60, 'maxlength' => 255]); ?><br/>
            <?php echo $form->error($model, 'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'parent_id'); ?><br/>
            <?php echo $form->dropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(GalleryCategory::model()->getTabList(), $model->getAssocList()) : GalleryCategory::model()->getTabList())); ?>
            <br/>
            <?php echo $form->error($model, 'parent_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'sort'); ?><br/>
            <?php echo $form->textField($model, 'sort', ['size' => 60, 'maxlength' => 255]); ?><br/>
            <?php echo $form->error($model, 'sort'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image) : ?>
            <div class="image">
                <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt=""/></a>
            </div>
            <div class="row">
                <?php echo $form->checkBox($model, 'del_image'); ?><?php echo $form->labelEx($model, 'del_image'); ?>
            </div>

        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'image'); ?><br/>
            <?php echo $form->fileField($model, 'image'); ?><br/>
            <?php echo $form->error($model, 'image'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model, 'text'); ?><br/>
            <?php echo $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80, 'class' => 'tinymce']); ?>
            <?php echo $form->error($model, 'text'); ?>
        </div>
    </fieldset>

    <?php echo $this->renderPartial('//common/forms/_meta', [
        'form' => $form,
        'model' => $model,
    ]); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
