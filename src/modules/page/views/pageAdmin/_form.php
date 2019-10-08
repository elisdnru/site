<?php
/* @var $this AdminController */

use app\components\AdminController;
use app\modules\page\models\Page;

/* @var $model Page */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget(\CActiveForm::class, [
        'id' => 'page-form',
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
        <h4>Основное</h4>
        <div class="row">
            <?php echo $form->checkBox($model, 'hidetitle'); ?> <?php echo $form->labelEx($model, 'hidetitle'); ?><br />
        </div>

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
        <hr />
        <div class="row">
            <?php echo $form->labelEx($model, 'parent_id'); ?><br />
            <?php echo $form->dropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Page::model()->getTabList(), $model->getAssocList()) : Page::model()->getTabList())); ?>
            <br />
            <?php echo $form->error($model, 'parent_id'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Шаблоны отображения</h4>
        <div class="row">
            <?php echo $form->labelEx($model, 'layout'); ?><br />
            <?php echo $form->dropDownList($model, 'layout', Page::LAYOUTS); ?>
            <br />
            <?php echo $form->error($model, 'layout'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'subpages_layout'); ?><br />
            <?php echo $form->dropDownList($model, 'subpages_layout', Page::SUBPAGES_LAYOUTS); ?>
            <br />
            <?php echo $form->error($model, 'subpages_layout'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image) : ?>
            <div class="image">
                <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt="" /></a>
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
            <?php echo $form->labelEx($model, 'image_alt'); ?><br />
            <?php echo $form->textField($model, 'image_alt', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'image_alt'); ?>
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

    <fieldset>
        <h4>Индексация</h4>
        <div class="row">
            <?php echo $form->labelEx($model, 'robots'); ?><br />
            <?php echo $form->dropDownList($model, 'robots', Page::model()->getRobotsList()); ?><br />
            <?php echo $form->error($model, 'robots'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
