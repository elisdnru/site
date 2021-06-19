<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\landing\models\Landing;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Landing $model
 * @var ActiveForm $form
 */
?>

<div class="form">

    <form action="?" method="post">

        <?= Csrf::hiddenInput(); ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']); ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

        <fieldset>
            <h4>Основное</h4>

            <div class="row<?= $model->hasErrors('title') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'title'); ?><br />
                <?= Html::activeTextInput($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'title', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('alias') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'alias'); ?><br />
                <?= Html::activeTextInput($model, 'alias', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'alias', ['class' => 'error-message']); ?>
            </div>
            <hr />
            <div class="row<?= $model->hasErrors('parent_id') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'parent_id'); ?><br />
                <?= Html::activeDropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Landing::find()->getTabList(), Landing::find()->getAssocList($model->id)) : Landing::find()->getTabList())); ?><br />
                <?= Html::error($model, 'parent_id', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('text') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'text'); ?><br />
                <?= Html::activeTextarea($model, 'text', ['rows' => 40, 'cols' => 80]); ?><br />
                <?= Html::error($model, 'text', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Индексация</h4>
            <div class="row<?= $model->hasErrors('system') ? ' error' : ''; ?>">
                <?= Html::activeCheckbox($model, 'system'); ?><br />
                <?= Html::error($model, 'system', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

    </form>

</div><!-- form -->
