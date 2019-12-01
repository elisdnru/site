<?php
/** @var $this \yii\web\View */

use app\modules\block\models\Block;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model Block */
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
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('text') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'text') ?><br />
                <?= Html::activeTextarea($model, 'text', ['rows' => 40, 'cols' => 80]) ?><br />
                <?= Html::error($model, 'text', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

    </form>

</div><!-- form -->
