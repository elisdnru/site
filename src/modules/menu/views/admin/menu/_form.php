<?php
/** @var $this \yii\web\View */

use app\components\AdminController;
use app\modules\menu\models\Menu;
use app\modules\page\models\Page;
use yii\web\View;

/** @var $model Menu */
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
            <?= $form->labelEx($model, 'parent_id') ?><br />
            <?= $form->dropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Menu::model()->getTabList(), $model->getAssocList()) : Menu::model()->getTabList())) ?>
            <br />
            <?= $form->error($model, 'parent_id') ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'sort') ?><br />
            <?= $form->textField($model, 'sort', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'sort') ?>
        </div>

        <div class="row">
            <?= $form->checkBox($model, 'visible') ?>
            <?= $form->labelEx($model, 'visible') ?><br />
            <?= $form->error($model, 'visible') ?>
        </div>
    </fieldset>


    <fieldset>
        <div class="row">
            <?= $form->labelEx($model, 'link') ?><br />
            <?= $form->textField($model, 'link', ['size' => 60, 'maxlength' => 255, 'class' => 'm_urlfield']) ?>
            <br />
            <?= $form->error($model, 'link') ?>
        </div>
        <hr />
        <div class="row">
            <label>Ссылка на страницу</label><br />
            <?= CHtml::dropDownList('sss', '/' . $model->link, ['' => ''] + Page::model()->getUrlList(), ['class' => 'm_selector']) ?>
            <br />
        </div>

    </fieldset>

    <fieldset>
        <div class="row">
            <?= $form->labelEx($model, 'alias') ?><br />
            <?= $form->textField($model, 'alias', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'alias') ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

    <script>
    <?php ob_start() ?>

    (function(){
      var url_field = document.querySelector('.m_urlfield');
      if (!url_field.value) {
        url_field.value = '#';
      }
      var selector = document.querySelector('.m_selector');
      selector.addEventListener('change', function (e) {
        var val = e.target.value;
        if (val === '') {
          url_field.value = '#';
        } else {
          url_field.value = e.target.value;
        }
        selector.value = '';
        e.target.value = val;
      })
    })();

    <?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
    </script>

</div><!-- form -->
