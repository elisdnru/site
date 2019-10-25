<?php
/** @var $this AdminController */

use app\components\AdminController;
use app\modules\page\models\Page;

/** @var $model Page */
/** @var $form CActiveForm */
?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'id' => 'page-form',
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
            <?= $form->checkBox($model, 'hidetitle') ?> <?= $form->labelEx($model, 'hidetitle') ?><br />
        </div>

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
            <?= $form->dropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Page::model()->getTabList(), $model->getAssocList()) : Page::model()->getTabList())) ?>
            <br />
            <?= $form->error($model, 'parent_id') ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Шаблоны отображения</h4>
        <div class="row">
            <?= $form->labelEx($model, 'layout') ?><br />
            <?= $form->dropDownList($model, 'layout', Page::LAYOUTS) ?>
            <br />
            <?= $form->error($model, 'layout') ?>
        </div>
        <div class="row">
            <?= $form->labelEx($model, 'subpages_layout') ?><br />
            <?= $form->dropDownList($model, 'subpages_layout', Page::SUBPAGES_LAYOUTS) ?>
            <br />
            <?= $form->error($model, 'subpages_layout') ?>
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
            <?= $form->labelEx($model, 'image_alt') ?><br />
            <?= $form->textField($model, 'image_alt', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'image_alt') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'text') ?><br />
            <?= $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80]) ?>
            <?= $form->error($model, 'text') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'styles') ?><br />
            <?= $form->textArea($model, 'styles', ['rows' => 10, 'cols' => 80]) ?>
            <?= $form->error($model, 'styles') ?>
        </div>
    </fieldset>

    <?= $this->renderPartial('//common/forms/_meta', [
        'form' => $form,
        'model' => $model,
    ]) ?>

    <fieldset>
        <h4>Индексация</h4>
        <div class="row">
            <?= $form->checkBox($model, 'system') ?> <?= $form->labelEx($model, 'system') ?><br />
        </div>
        <div class="row">
            <?= $form->labelEx($model, 'robots') ?><br />
            <?= $form->dropDownList($model, 'robots', Page::model()->getRobotsList()) ?><br />
            <?= $form->error($model, 'robots') ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
