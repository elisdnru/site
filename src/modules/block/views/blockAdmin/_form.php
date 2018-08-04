<?php
/* @var $this DAdminController */
/* @var $model Block */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'block-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('enctype'=>'multipart/form-data')
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
            <?php echo $form->labelEx($model,'alias'); ?>&nbsp;<a href="javascript:transliterate('Block_title', 'Block_alias')">Транслит наименования</a><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>
    </fieldset>

    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <fieldset class="editor">
            <div class="row">
                <?php echo $form->labelEx($model,'text'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textArea($model,'text'.$suffix,array('rows'=>40, 'cols'=>80)); ?><br />
                <?php echo $form->error($model,'text'.$suffix); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
