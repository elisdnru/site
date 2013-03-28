<?php $this->beginWidget('DPortlet', array('title'=>'Позвоните мне')); ?>

<?php if(Yii::app()->user->hasFlash('contactForm')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('contactForm'); ?>
</div>

<?php endif; ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>array('/callme/default/index'),
    'id'=>'contact-form',
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>false,
    ),
)); ?>

    <div class="row">
        <?php echo $form->textField($model,'name',array('size'=>30, 'placeholder'=>'ФИО', 'title'=>'ФИО')); ?><br />
        <?php echo $form->textField($model,'phone',array('size'=>30, 'placeholder'=>'Телефон', 'title'=>'Телефон')); ?><br />
        <?php echo $form->textArea($model,'text',array('rows'=>4, 'cols'=>50, 'placeholder'=>'Когда позвонить?', 'title'=>'Когда позвонить?')); ?>
    </div>

    <div class="row">
        <div style="float:right">
            <?php $this->widget('CCaptcha',array('buttonLabel'=>'<br />Показать другой код<br />', 'captchaAction'=>'/callme/default/captcha')); ?>
        </div>
        <?php echo $form->labelEx($model,'verifyCode'); ?><br />
        <?php echo $form->textField($model,'verifyCode',array('size'=>22)); ?>
        <?php echo $form->error($model,'verifyCode'); ?>
    </div>
    <div class="clear"></div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить'); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>