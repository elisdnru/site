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

        <div class="row">
            <?= $form->labelEx($model, 'category_id') ?><br />
            <?= $form->dropDownList($model, 'category_id', ['' => ''] + Category::model()->getTabList()) ?>
            <br />
            <?= $form->error($model, 'category_id') ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'date') ?><br />
            <?= $form->textField($model, 'date', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'date') ?>
        </div>

        <div class="row">
            <?= $form->checkBox($model, 'public') ?>
            <?= $form->labelEx($model, 'public') ?><br />
            <?= $form->error($model, 'public') ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image) : ?>
            <div class="image">
                <a target="_blank" class="clightbox" href="<?= $model->imageUrl ?>"><img src="<?= $model->imageThumbUrl ?>" alt=""></a>
            </div>
            <div class="row">
                <?= $form->checkBox($model, 'del_image') ?><?= $form->labelEx($model, 'del_image') ?>
            </div>

        <?php endif; ?>

        <div class="row">
            <?= $form->labelEx($model, 'image') ?><br />
            <?= $form->fileField($model, 'image') ?><br />
            <?= $form->error($model, 'image') ?>
        </div>
        <div class="row">
            <?= $form->checkbox($model, 'image_show') ?>
            <?= $form->labelEx($model, 'image_show') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'short') ?><br />
            <?= $form->textArea($model, 'short', ['rows' => 6, 'cols' => 80]) ?>
            <?= $form->error($model, 'short') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'text') ?><br />
            <?= $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80]) ?>
            <?= $form->error($model, 'text') ?>
        </div>
    </fieldset>

    <?= $this->renderPartial('//common/forms/_meta', [
        'form' => $form,
        'model' => $model,
    ]) ?>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
