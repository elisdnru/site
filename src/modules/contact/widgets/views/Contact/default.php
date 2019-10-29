<?php
/** @var $form CActiveForm */

use app\components\widgets\Portlet;
use yii\helpers\Html;

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

    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <?= $form->errorSummary($model) ?>

    <div class="row">
        <?= $form->labelEx($model, 'name') ?><br />
        <?= $form->textField($model, 'name', ['size' => 40]) ?><br />
        <?= $form->error($model, 'name') ?>
    </div>

    <div class="row">
        <?= $form->labelEx($model, 'email') ?><br />
        <?= $form->textField($model, 'email', ['size' => 40]) ?><br />
        <?= $form->error($model, 'email') ?>
    </div>

    <div class="row">
        <?= $form->labelEx($model, 'phone') ?><br />
        <?= $form->textField($model, 'phone', ['size' => 40]) ?><br />
        <?= $form->error($model, 'phone') ?>
    </div>

    <div class="row">
        <?= $form->labelEx($model, 'text') ?><br />
        <?= $form->textArea($model, 'text', ['rows' => 8, 'cols' => 50, 'style' => 'width:99%']) ?>
        <br />
        <?= $form->error($model, 'text') ?>
    </div>

    <div class="row">
        <?= $form->labelEx($model, 'verifyCode') ?><br />
        <?= $form->textField($model, 'verifyCode', ['size' => 22]) ?>
        <?= $form->error($model, 'verifyCode') ?>
        <div>
            <?php Yii::app()->controller->widget(CCaptcha::class, ['buttonLabel' => '<br />Показать другой код<br />', 'captchaAction' => '/contact/default/captcha']); ?>
        </div>
    </div>

    <br />

    <div class="row">
        <?= $form->checkBox($model, 'accept') ?>
        <?= $form->labelEx($model, 'accept') ?><br />
        <?= $form->error($model, 'accept') ?>
    </div>

    <br />

    <div class="row buttons">
        <?= Html::submitButton('Отправить сообщение') ?>
    </div>
    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->

<?php Portlet::end(); ?>
