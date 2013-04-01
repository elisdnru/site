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
            <?php echo $form->labelEx($model,'alias'); ?>&nbsp;<a href="javascript:transliterate('RubricatorArticle_title', 'RubricatorArticle_alias')">Транслит наименования</a><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'date'); ?><br />
            <?php echo $form->textField($model,'date',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'date'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'category_id'); ?><br />
            <?php echo $form->dropDownList($model,'category_id',array('0'=>'') + RubricatorCategory::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'category_id'); ?>
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
            <?php echo $form->labelEx($model,'image_alt'); ?><br />
            <?php echo $form->textField($model,'image_alt',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'image_alt'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Связанные страницы</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'articles_newspage_id'); ?><br />
            <?php echo $form->dropDownList($model,'articles_newspage_id',array('0'=>'') + NewsPage::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'articles_newspage_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'photos_newspage_id'); ?><br />
            <?php echo $form->dropDownList($model,'photos_newspage_id',array('0'=>'') + NewsPage::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'photos_newspage_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'videos_newspage_id'); ?><br />
            <?php echo $form->dropDownList($model,'videos_newspage_id',array('0'=>'') + NewsPage::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'videos_newspage_id'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Фотогалерея</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'gallery_id'); ?><br />
            <?php echo $form->dropDownList($model,'gallery_id',array('0'=>'') + Gallery::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'gallery_id'); ?>
            <a class="floatright" href="<?php echo $this->createUrl('admin/galleries/update'); ?>">Создать новую галерею</a>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model,'short'); ?><br />
            <?php echo $form->textArea($model,'short',array('rows'=>16, 'cols'=>80, 'class'=>'tinymce')); ?>
            <?php echo $form->error($model,'short'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?><br />
            <?php echo $form->textArea($model,'text',array('rows'=>40, 'cols'=>80, 'class'=>'tinymce')); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </fieldset>

    <?php echo $this->renderPartial('//common/forms/_lang_meta', array(
        'form'=>$form,
        'model'=>$model,
    )); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
