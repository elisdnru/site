<?php $form=$this->beginWidget('DPortlet', array('title'=>'Обратная связь')); ?>

<?php if(Yii::app()->user->hasFlash('contactForm')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('contactForm'); ?>
</div>

<?php endif; ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>'#contact-form',
    'id'=>'contact-form',
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>false,
    ),
)); ?>

    <div class="row inp_text">
        <?php echo $form->textField($model,'name',array('placeholder'=>'ФИО', 'title'=>'ФИО')); ?><br />
        <?php echo $form->textField($model,'email',array('placeholder'=>'Email', 'title'=>'Email')); ?><br />
        <?php echo $form->textArea($model,'text',array('rows'=>4, 'cols'=>30, 'placeholder'=>'Сообщение', 'title'=>'Сообщение')); ?><br />
        <?php echo $form->checkBox($model,'accept'); ?><?php echo $form->labelEx($model,'accept'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить'); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>