<?php
/* @var $this AdminController */

use app\modules\comment\models\Comment;
use app\components\AdminController;

/* @var $model Comment */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'id' => 'block-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model, 'date'); ?><br />
            <?php echo $form->textField($model, 'date', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'date'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'parent_id'); ?><br />
            <?php echo $form->textField($model, 'parent_id', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'parent_id'); ?>
        </div>
        <?php if ($model->user) : ?>
            <p class="nomargin">
                <a href="<?php echo $this->createUrl('/user/admin/user/update', ['id' => $model->user_id]); ?>"><?php echo $model->user->fio; ?></a>
            </p>
        <?php else : ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'name'); ?><br />
                <?php echo $form->textField($model, 'name', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model, 'email'); ?><br />
                <?php echo $form->textField($model, 'email', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model, 'site'); ?><br />
                <?php echo $form->textField($model, 'site', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?php echo $form->error($model, 'site'); ?>
            </div>
        <?php endif; ?>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model, 'text'); ?><br />
            <?php echo $form->textArea($model, 'text', ['rows' => 20, 'cols' => 80]); ?><br />
            <?php echo $form->error($model, 'text'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
