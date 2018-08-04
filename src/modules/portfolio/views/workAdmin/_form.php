<?php
/* @var $this DAdminController */
/* @var $model PortfolioWork */
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

        <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
            <div class="row">
                <?php echo $form->labelEx($model,'title'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textField($model, 'title' . $suffix, array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model, 'title' . $suffix); ?>
            </div>
        <?php endforeach; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'alias'); ?>&nbsp;<a href="javascript:transliterate('PortfolioWork_title', 'PortfolioWork_alias')">Транслит наименования</a><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'category_id'); ?><br />
            <?php echo $form->dropDownList($model,'category_id',array(''=>'') + PortfolioCategory::model()->getTabList()); ?><br />
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
            <?php echo $form->checkbox($model,'image_show'); ?>
            <?php echo $form->labelEx($model,'image_show'); ?>
        </div>
    </fieldset>

    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <fieldset class="editor">
            <div class="row">
                <?php echo $form->labelEx($model,'short'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textArea($model, 'short' . $suffix, array('rows'=>16, 'cols'=>80, 'class'=>'tinymce')); ?>
                <?php echo $form->error($model, 'short' . $suffix); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <fieldset class="editor">
            <div class="row">
                <?php echo $form->labelEx($model,'text'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textArea($model, 'text' . $suffix, array('rows'=>40, 'cols'=>80, 'class'=>'tinymce')); ?>
                <?php echo $form->error($model, 'text' . $suffix); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <?php echo $this->renderPartial('//common/forms/_lang_meta', array(
        'form'=>$form,
        'model'=>$model,
    )); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
