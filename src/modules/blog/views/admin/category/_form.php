<?php
/** @var $this \yii\web\View */

use app\modules\blog\models\Category;
use app\components\AdminController;

/** @var $model Category */
/** @var $form CActiveForm */
?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'id' => 'page-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?= $form->errorSummary($model) ?>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <fieldset>
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

        <div class="row">
            <?= $form->labelEx($model, 'parent_id') ?><br />
            <?= $form->dropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Category::model()->getTabList(), $model->getAssocList()) : Category::model()->getTabList())) ?>
            <br />
            <?= $form->error($model, 'parent_id') ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'sort') ?><br />
            <?= $form->textField($model, 'sort', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'sort') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'text') ?><br />
            <?= $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80]) ?>
            <?= $form->error($model, 'text') ?>
        </div>
    </fieldset>

    <?= $this->render('//common/forms/_meta', [
        'form' => $form,
        'model' => $model,
    ]) ?>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
