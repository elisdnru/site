<?php
/* @var $this AdminController */

use app\components\AdminController;
use app\modules\menu\models\Menu;
use app\modules\page\models\Page;

/* @var $model Menu */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerCoreScript('jquery');
?>

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

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>

        <div class="row">
            <?php echo $form->labelEx($model, 'title'); ?><br />
            <?php echo $form->textField($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'parent_id'); ?><br />
            <?php echo $form->dropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Menu::model()->getTabList(), $model->getAssocList()) : Menu::model()->getTabList())); ?>
            <br />
            <?php echo $form->error($model, 'parent_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'sort'); ?><br />
            <?php echo $form->textField($model, 'sort', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'sort'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model, 'visible'); ?>
            <?php echo $form->labelEx($model, 'visible'); ?><br />
            <?php echo $form->error($model, 'visible'); ?>
        </div>
    </fieldset>


    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model, 'link'); ?><br />
            <?php echo $form->textField($model, 'link', ['size' => 60, 'maxlength' => 255, 'class' => 'm_urlfield']); ?>
            <br />
            <?php echo $form->error($model, 'link'); ?>
        </div>
        <hr />
        <div class="row">
            <label>Ссылка на страницу</label><br />
            <?php echo CHtml::dropDownList('sss', '/' . $model->link, ['' => ''] + Page::model()->getUrlList(), ['class' => 'm_selector']); ?>
            <br />
        </div>

    </fieldset>

    <fieldset>
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

    <script>
    <?php ob_start() ?>

    jQuery(function($){
      var url_field = $('.m_urlfield');
      if (!url_field.val()) {
        url_field.val('#');
      }
      var selector = $('.m_selector');
      selector.change(function () {
        var val = $(this).val()
        if (val === '') {
          url_field.val('#')
        } else {
          url_field.val($(this).val())
        }
        selector.val('')
        $(this).val(val)
      })
    });

    <?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
    </script>

</div><!-- form -->