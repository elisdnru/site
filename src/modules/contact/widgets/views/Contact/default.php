<?php $this->beginWidget('DPortlet', array('title'=>'Отправить сообщение')); ?>

<?php if(Yii::app()->user->hasFlash('contactForm')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('contactForm'); ?>
</div>

<?php endif; ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'contact-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?><br />
        <?php echo $form->textField($model,'name',array('size'=>40)); ?><br />
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?><br />
        <?php echo $form->textField($model,'email',array('size'=>40)); ?><br />
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'phone'); ?><br />
        <?php echo $form->textField($model,'phone',array('size'=>40)); ?><br />
        <?php echo $form->error($model,'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'text'); ?><br />
        <?php echo $form->textArea($model,'text',array('rows'=>8, 'cols'=>50, 'style'=>'width:99%')); ?><br />
        <?php echo $form->error($model,'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'verifyCode'); ?><br />
        <?php echo $form->textField($model,'verifyCode',array('size'=>22)); ?>
        <?php echo $form->error($model,'verifyCode'); ?>
        <div>
            <?php $this->widget('CCaptcha',array('buttonLabel'=>'<br />Показать другой код<br />', 'captchaAction'=>'/contact/default/captcha')); ?>
        </div>
    </div>

    <br />

    <div class="row">
        <?php echo $form->checkBox($model,'accept'); ?>
        <?php echo $form->labelEx($model,'accept'); ?><br />
        <?php echo $form->error($model,'accept'); ?>
    </div>

    <br />

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить сообщение'); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>