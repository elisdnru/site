<?php
/* @var $this DAdminController */
/* @var $model RubrikatorCategory */
/* @var $form CActiveForm */
?>
<div id="admin">
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
    <br />
    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <h4>Изображение</h4>

        <div class="row">
            <?php echo $form->labelEx($model,'file'); ?><br />
            <?php echo $form->fileField($model,'file'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
</div>