<?php
/* @var $this DAdminController */
/* @var $model BlogCategory */
/* @var $form CActiveForm */
?>

<?php $this->widget('tinymce.widgets.TinyMCEWidget'); ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'page-form',
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
        <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
            <div class="row">
                <?php echo $form->labelEx($model,'title'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textField($model,'title'.$suffix,array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model,'title'.$suffix); ?>
            </div>
        <?php endforeach; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'alias'); ?>&nbsp;<a href="javascript:transliterate('BlogCategory_title', 'BlogCategory_alias')">Транслит наименования</a><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'parent_id'); ?><br />
            <?php echo $form->dropDownList($model,'parent_id',array(0=>'') + array_diff_key(BlogCategory::model()->getTabList(), $model->getAssocList())); ?><br />
            <?php echo $form->error($model,'parent_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sort'); ?><br />
            <?php echo $form->textField($model,'sort',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'sort'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?><br />
            <?php echo $form->textArea($model,'text',array('rows'=>40, 'cols'=>80, 'class'=>'tinymce')); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Мета-информация</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'pagetitle'); ?><br />
            <?php echo $form->textField($model,'pagetitle',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'pagetitle'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'description'); ?><br />
            <?php echo $form->textArea($model,'description',array('rows'=>3, 'cols'=>80)); ?><br />
            <?php echo $form->error($model,'description'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'keywords'); ?><br />
            <?php echo $form->textField($model,'keywords',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'keywords'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->