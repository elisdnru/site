<?php
/* @var $this DController */
/* @var $reviewForm ReviewForm */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('DPortlet', array('title'=>'Оставить отзыв')); ?>

<?php if(Yii::app()->user->hasFlash('reviewForm')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('reviewForm'); ?>
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

    <?php echo $form->errorSummary($reviewForm); ?>

    <div class="row">
        <?php echo $form->labelEx($reviewForm,'name'); ?><br />
        <?php echo $form->textField($reviewForm,'name',array('size'=>40)); ?><br />
        <?php echo $form->error($reviewForm,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($reviewForm,'email'); ?><br />
        <?php echo $form->textField($reviewForm,'email',array('size'=>40)); ?><br />
        <?php echo $form->error($reviewForm,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($reviewForm,'text'); ?><br />
        <?php echo $form->textArea($reviewForm,'text',array('rows'=>8, 'cols'=>50, 'style'=>'width:100%')); ?><br />
        <?php echo $form->error($reviewForm,'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($reviewForm,'verifyCode'); ?><br />
        <?php echo $form->textField($reviewForm,'verifyCode',array('size'=>22)); ?>
        <?php echo $form->error($reviewForm,'verifyCode'); ?>
        <div>
            <?php $this->widget('CCaptcha',array('buttonLabel'=>'<br />Показать другой код<br />', 'id'=>'captha')); ?>
        </div>
    </div>

    <br />

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить сообщение'); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>