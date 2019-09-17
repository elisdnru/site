<?php $form = $this->beginWidget(\app\modules\main\components\widgets\Portlet::class, ['title' => 'Обратная связь']); ?>

<?php if (Yii::app()->user->hasFlash('contactForm')) : ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('contactForm'); ?>
    </div>

<?php endif; ?>

<div class="form">

    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'action' => '#contact-form',
        'id' => 'contact-form',
        'enableClientValidation' => false,
        'clientOptions' => [
            'validateOnSubmit' => false,
        ],
    ]); ?>

    <div class="row inp_text">
        <?php echo $form->textField($model, 'name', ['placeholder' => 'ФИО', 'title' => 'ФИО']); ?><br />
        <?php echo $form->textField($model, 'email', ['placeholder' => 'Email', 'title' => 'Email']); ?><br />
        <?php echo $form->textArea($model, 'text', ['rows' => 4, 'cols' => 30, 'placeholder' => 'Сообщение', 'title' => 'Сообщение']); ?>
        <br />
        <?php echo $form->checkBox($model, 'accept'); ?><?php echo $form->labelEx($model, 'accept'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить'); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->endWidget(); ?>
