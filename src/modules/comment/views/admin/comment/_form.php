<?php
/** @var $this AdminController */

use app\modules\comment\models\Comment;
use app\components\AdminController;

/** @var $model Comment */
/** @var $form CActiveForm */
?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'id' => 'block-form',
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
        <div class="row">
            <?= $form->labelEx($model, 'date') ?><br />
            <?= $form->textField($model, 'date', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'date') ?>
        </div>
        <div class="row">
            <?= $form->labelEx($model, 'parent_id') ?><br />
            <?= $form->textField($model, 'parent_id', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'parent_id') ?>
        </div>
        <?php if ($model->user) : ?>
            <p class="nomargin">
                <a href="<?= $this->createUrl('/user/admin/user/update', ['id' => $model->user_id]) ?>"><?= $model->user->fio ?></a>
            </p>
        <?php else : ?>
            <div class="row">
                <?= $form->labelEx($model, 'name') ?><br />
                <?= $form->textField($model, 'name', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= $form->error($model, 'name') ?>
            </div>
            <div class="row">
                <?= $form->labelEx($model, 'email') ?><br />
                <?= $form->textField($model, 'email', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= $form->error($model, 'email') ?>
            </div>
            <div class="row">
                <?= $form->labelEx($model, 'site') ?><br />
                <?= $form->textField($model, 'site', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= $form->error($model, 'site') ?>
            </div>
        <?php endif; ?>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'text') ?><br />
            <?= $form->textArea($model, 'text', ['rows' => 20, 'cols' => 80]) ?><br />
            <?= $form->error($model, 'text') ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
