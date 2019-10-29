<?php
/** @var $form CActiveForm */

use app\components\widgets\Portlet;
use yii\helpers\Html;

/** @var $model \app\modules\contact\forms\ContactForm */
?>

<?php Portlet::begin(['title' => 'Обратная связь']); ?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'action' => '#contact-form',
        'id' => 'contact-form',
        'enableClientValidation' => false,
        'clientOptions' => [
            'validateOnSubmit' => false,
        ],
    ]); ?>

    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <div class="row inp_text">
        <?= $form->textField($model, 'name', ['placeholder' => 'ФИО', 'title' => 'ФИО']) ?><br />
        <?= $form->textField($model, 'email', ['placeholder' => 'Email', 'title' => 'Email']) ?><br />
        <?= $form->textArea($model, 'text', ['rows' => 4, 'cols' => 30, 'placeholder' => 'Сообщение', 'title' => 'Сообщение']) ?>
        <br />
        <?= $form->checkBox($model, 'accept') ?><?= $form->labelEx($model, 'accept') ?>
    </div>

    <div class="row buttons">
        <?= CHtml::submitButton('Отправить') ?>
    </div>
    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->

<?php Portlet::end(); ?>
