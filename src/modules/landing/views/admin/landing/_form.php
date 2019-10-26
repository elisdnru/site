<?php
/** @var $this \yii\web\View */

use app\components\AdminController;
use app\modules\landing\models\Landing;

/** @var $model Landing */
/** @var $form CActiveForm */
?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'id' => 'landing-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?= $form->errorSummary($model) ?>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <fieldset>
        <h4>Основное</h4>

        <div class="row">
            <?= $form->labelEx($model, 'title') ?><br />
            <?= $form->textField($model, 'title', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'title') ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'alias') ?><br />
            <?= $form->textField($model, 'alias', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'alias') ?>
        </div>
        <hr />
        <div class="row">
            <?= $form->labelEx($model, 'parent_id') ?><br />
            <?= $form->dropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Landing::model()->getTabList(), $model->getAssocList()) : Landing::model()->getTabList())) ?>
            <br />
            <?= $form->error($model, 'parent_id') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'text') ?><br />
            <?= $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80]) ?>
            <?= $form->error($model, 'text') ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Индексация</h4>
        <div class="row">
            <?= $form->checkBox($model, 'system') ?> <?= $form->labelEx($model, 'system') ?><br />
        </div>
    </fieldset>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
