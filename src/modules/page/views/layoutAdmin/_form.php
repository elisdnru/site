<?php
/* @var $this DAdminController */

use app\modules\main\components\DAdminController;
use app\modules\page\models\PageLayout;

/* @var $model PageLayout */
/* @var $form CActiveForm */
?>
<?php $this->widget(\app\modules\tinymce\widgets\TinyMCEWidget::class); ?>

<div class="form">

    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'id' => 'page-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <h4>Основное</h4>
        <div class="row">
            <?php echo $form->labelEx($model, 'title'); ?><br />
            <?php echo $form->textField($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'title'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'alias'); ?><br />
            <?php echo $form->textField($model, 'alias', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'alias'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
