<?php
/** @var $form CActiveForm */

use app\components\widgets\Portlet;

/** @var $model \app\modules\contact\forms\ContactForm */
?>

<?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Обратная связь']); ?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
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
    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->controller->endWidget(); ?>
