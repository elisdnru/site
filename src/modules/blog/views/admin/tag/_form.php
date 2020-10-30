<?php
/** @var $this View */

use app\modules\blog\models\Tag;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var $model Tag */
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
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

    </form>

</div><!-- form -->
