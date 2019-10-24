<?php
/** @var $this AdminController */

use app\components\AdminController;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;

/** @var $model Work */
/** @var $form CActiveForm */
?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(
        'CActiveForm',
        [
            'id' => 'new-form',
            'enableClientValidation' => true,
            'clientOptions' => [
                'validateOnSubmit' => true,
            ],
            'htmlOptions' => ['enctype' => 'multipart/form-data']
        ]
    ); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

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

        <div class="row">
            <?php echo $form->labelEx($model, 'category_id'); ?><br />
            <?php echo $form->dropDownList($model, 'category_id', ['' => ''] + Category::model()->getTabList()); ?>
            <br />
            <?php echo $form->error($model, 'category_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'date'); ?><br />
            <?php echo $form->textField($model, 'date', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'date'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model, 'public'); ?>
            <?php echo $form->labelEx($model, 'public'); ?><br />
            <?php echo $form->error($model, 'public'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image) : ?>
            <div class="image">
                <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt=""></a>
            </div>
            <div class="row">
                <?php echo $form->checkBox($model, 'del_image'); ?><?php echo $form->labelEx($model, 'del_image'); ?>
            </div>

        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'image'); ?><br />
            <?php echo $form->fileField($model, 'image'); ?><br />
            <?php echo $form->error($model, 'image'); ?>
        </div>
        <div class="row">
            <?php echo $form->checkbox($model, 'image_show'); ?>
            <?php echo $form->labelEx($model, 'image_show'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model, 'short'); ?><br />
            <?php echo $form->textArea($model, 'short', ['rows' => 6, 'cols' => 80]); ?>
            <?php echo $form->error($model, 'short'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model, 'text'); ?><br />
            <?php echo $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80]); ?>
            <?php echo $form->error($model, 'text'); ?>
        </div>
    </fieldset>

    <?php echo $this->renderPartial('//common/forms/_meta', [
        'form' => $form,
        'model' => $model,
    ]); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
