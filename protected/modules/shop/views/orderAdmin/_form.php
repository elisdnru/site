<?php
/* @var $this DAdminController */
/* @var $model ShopOrder */
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
        'htmlOptions'=>array('enctype'=>'multipart/form-data')
    )
); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>
        <h4>Заказ</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'date'); ?><br />
            <?php echo $form->textField($model,'date',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'date'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'post_id'); ?><br />
            <?php echo $form->dropDownList($model,'post_id',array(''=>'') + ShopPostType::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'post_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'postcode'); ?><br />
            <?php echo $form->textField($model,'postcode',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'postcode'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'comment'); ?><br />
            <?php echo $form->textArea($model,'comment',array('rows'=>4, 'cols'=>60)); ?><br />
            <?php echo $form->error($model,'comment'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Получатель</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'lastname'); ?><br />
            <?php echo $form->textField($model,'lastname',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'lastname'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?><br />
            <?php echo $form->textField($model,'name',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'middlename'); ?><br />
            <?php echo $form->textField($model,'middlename',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'middlename'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?><br />
            <?php echo $form->textField($model,'email',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'phone'); ?><br />
            <?php echo $form->textField($model,'phone',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'phone'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'zip'); ?><br />
            <?php echo $form->textField($model,'zip',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'zip'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'address'); ?><br />
            <?php echo $form->textArea($model,'address',array('rows'=>4, 'cols'=>60)); ?><br />
            <?php echo $form->error($model,'address'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
