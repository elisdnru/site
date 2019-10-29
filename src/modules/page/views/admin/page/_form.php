<?php
/** @var $this View */

use app\modules\page\models\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $model Page */
/** @var $form CActiveForm */
?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(CActiveForm::class, [
        'action' => Url::current(),
        'id' => 'page-form',
        'enableClientValidation' => true,
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?= $form->errorSummary($model) ?>

    <div class="row buttons">
        <?= Html::submitButton('Сохранить') ?>
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

    <?= $this->render('//common/forms/_meta', [
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
        <?= Html::submitButton('Сохранить') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
