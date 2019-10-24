<?php
/** @var $form CActiveForm */

use app\components\widgets\Portlet;

/** @var $model \app\modules\contact\forms\ContactForm */
?>
<?php Portlet::begin(['title' => 'Отправить сообщение']); ?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'id' => 'contact-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?><br />
        <?php echo $form->textField($model, 'name', ['size' => 40]); ?><br />
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?><br />
        <?php echo $form->textField($model, 'email', ['size' => 40]); ?><br />
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'phone'); ?><br />
        <?php echo $form->textField($model, 'phone', ['size' => 40]); ?><br />
        <?php echo $form->error($model, 'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?><br />
        <?php echo $form->textArea($model, 'text', ['rows' => 8, 'cols' => 50, 'style' => 'width:99%']); ?>
        <br />
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'verifyCode'); ?><br />
        <?php echo $form->textField($model, 'verifyCode', ['size' => 22]); ?>
        <?php echo $form->error($model, 'verifyCode'); ?>
        <div>
            <?php $this->widget(CCaptcha::class, ['buttonLabel' => '<br />Показать другой код<br />', 'captchaAction' => '/contact/default/captcha']); ?>
        </div>
    </div>

    <br />

    <div class="row">
        <?php echo $form->checkBox($model, 'accept'); ?>
        <?php echo $form->labelEx($model, 'accept'); ?><br />
        <?php echo $form->error($model, 'accept'); ?>
    </div>

    <br />

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить сообщение'); ?>
    </div>
    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->

<?php Portlet::end(); ?>
