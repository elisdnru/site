<?php
/* @var $this DAdminController */
/* @var $model UserAttribute */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm',
    array(
        'id'=>'new-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )
); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>
    <br />
    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <br />

    <fieldset>
        <h4>Атрибут</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'label'); ?><br />
            <?php echo $form->textField($model,'label',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'label'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?><br />
            <?php echo $form->textField($model,'name',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'class'); ?><br />
            <?php echo $form->dropDownList($model,'class',array('User'=>'Пользователь')); ?><br />
            <?php echo $form->error($model,'class'); ?>
        </div>
    </fieldset>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'sort'); ?><br />
            <?php echo $form->textField($model,'sort',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'sort'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Формат</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'type'); ?><br />
            <?php echo $form->dropDownList($model,'type',UserAttribute::getTypes()); ?><br />
            <?php echo $form->error($model,'type'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'rule'); ?><br />
            <?php echo $form->dropDownList($model,'rule',UserAttribute::getRules()); ?><br />
            <?php echo $form->error($model,'rule'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'required'); ?>
            <?php echo $form->labelEx($model,'required'); ?><br />
            <?php echo $form->error($model,'required'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->