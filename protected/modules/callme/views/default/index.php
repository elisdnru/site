<?php
/* @var $this DController */

$this->pageTitle = 'Заказ обратного звонка';
$this->description = '';
$this->keywords = '';

$this->breadcrumbs=array(
    'Обратный звонок',
);

if ($this->is(Access::ROLE_CONTROL))
{
    if ($this->moduleAllowed('callme')) $this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin'));
    if ($this->moduleAllowed('callme') && Yii::app()->moduleManager->active('callme')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));

    $this->info = 'Обратный звонок';
}
?>

<h1>Заказ обратного звонка</h1>

<?php $this->beginWidget('DPortlet'); ?>

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

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?><br />
        <?php echo $form->textField($model,'name',array('size'=>40)); ?><br />
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'phone'); ?><br />
        <?php echo $form->textField($model,'phone',array('size'=>40)); ?><br />
        <?php echo $form->error($model,'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'text'); ?><br />
        <?php echo $form->textArea($model,'text',array('rows'=>3, 'cols'=>50)); ?><br />
        <?php echo $form->error($model,'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'verifyCode'); ?><br />
        <?php echo $form->textField($model,'verifyCode',array('size'=>22)); ?>
        <?php echo $form->error($model,'verifyCode'); ?>
        <div>
            <?php $this->widget('CCaptcha',array('buttonLabel'=>'<br />Показать другой код<br />', 'captchaAction'=>'/callme/default/captcha')); ?>
        </div>
    </div>

    <br />

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить'); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>