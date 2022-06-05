<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\block\models\Block;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Block $model
 * @var ActiveForm $form
 */
?>

<div class="form">

    <form action="?" method="post">

        <?= Csrf::hiddenInput(); ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'error-summary']); ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

        <fieldset>
            <div class="row<?= $model->hasErrors('title') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'title'); ?><br />
                <?= Html::activeTextInput($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'title', ['class' => 'error-message']); ?>
            </div>
            <div class="row<?= $model->hasErrors('slug') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'slug'); ?><br />
                <?= Html::activeTextInput($model, 'slug', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'slug', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('text') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'text'); ?><br />
                <?= Html::activeTextarea($model, 'text', ['rows' => 40, 'cols' => 80]); ?><br />
                <?= Html::error($model, 'text', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

    </form>

</div><!-- form -->
