<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\blog\models\Tag;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Tag $model
 * @var ActiveForm $form
 */
?>

<div class="form">

    <form action="?" method="post">

        <?= Csrf::hiddenInput(); ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'error-summary']); ?>

        <fieldset>
            <div class="row<?= $model->hasErrors('title') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'title'); ?><br />
                <?= Html::activeTextInput($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'title', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

    </form>

</div><!-- form -->
