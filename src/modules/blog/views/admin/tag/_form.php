<?php
/** @var $this AdminController */

use app\modules\blog\models\Tag;
use app\components\AdminController;

/** @var $model Tag */
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

    <?php echo $form->errorSummary($model); ?>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model, 'title'); ?><br />
            <?php echo $form->textField($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'title'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
