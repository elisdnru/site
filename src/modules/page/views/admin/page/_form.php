<?php
/** @var $this View */

use app\modules\page\models\Page;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var $model Page */
/** @var $form ActiveForm */
?>

<div class="form">

    <form action="?" method="post">

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']) ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

        <fieldset>
            <h4>Основное</h4>

            <div class="row<?= $model->hasErrors('hidetitle') ? ' error' : '' ?>">
                <?= Html::activeCheckbox($model, 'hidetitle') ?><br />
                <?= Html::error($model, 'hidetitle', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('title') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'title') ?><br />
                <?= Html::activeTextInput($model, 'title', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'title', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('alias') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'alias') ?><br />
                <?= Html::activeTextInput($model, 'alias', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'alias', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('parent_id') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'parent_id') ?><br />
                <?= Html::activeDropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Page::find()->getTabList(), Page::find()->getAssocList($model->id)) : Page::find()->getTabList())) ?><br />
                <?= Html::error($model, 'parent_id', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Шаблоны отображения</h4>

            <div class="row<?= $model->hasErrors('layout') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'layout') ?><br />
                <?= Html::activeDropDownList($model, 'layout', Page::LAYOUTS) ?><br />
                <?= Html::error($model, 'layout', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('subpages_layout') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'subpages_layout') ?><br />
                <?= Html::activeDropDownList($model, 'subpages_layout', Page::SUBPAGES_LAYOUTS) ?><br />
                <?= Html::error($model, 'subpages_layout', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('text') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'text') ?><br />
                <?= Html::activeTextarea($model, 'text', ['rows' => 40, 'cols' => 80]) ?><br />
                <?= Html::error($model, 'text', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <fieldset>
            <div class="row<?= $model->hasErrors('styles') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'styles') ?><br />
                <?= Html::activeTextarea($model, 'styles', ['rows' => 10, 'cols' => 80]) ?><br />
                <?= Html::error($model, 'styles', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <?= $this->render('//common/forms/v2/_meta', ['model' => $model]) ?>

        <fieldset>
            <h4>Индексация</h4>
            <div class="row<?= $model->hasErrors('system') ? ' error' : '' ?>">
                <?= Html::activeCheckbox($model, 'system') ?><br />
                <?= Html::error($model, 'system', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('robots') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'robots') ?><br />
                <?= Html::activeDropDownList($model, 'robots', Page::robotsList()) ?><br />
                <?= Html::error($model, 'robots', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

    </form>

</div><!-- form -->
