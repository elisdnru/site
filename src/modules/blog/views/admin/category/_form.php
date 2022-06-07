<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\blog\models\Category;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Category $model
 * @var ActiveForm $form
 */
?>

<div class="form">

    <form action="?" method="post">

        <?= Csrf::hiddenInput(); ?>

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

            <div class="row<?= $model->hasErrors('parent_id') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'parent_id'); ?><br />
                <?= Html::activeDropDownList($model, 'parent_id', $model->parent_id ? array_diff_key(Category::find()->getTabList(), Category::find()->getAssocList($model->id)) : Category::find()->getTabList(), ['prompt' => '']); ?><br />
                <?= Html::error($model, 'parent_id', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('sort') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'sort'); ?><br />
                <?= Html::activeTextInput($model, 'sort', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'sort', ['class' => 'error-message']); ?>
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
            <h4>Мета-информация</h4>
            <div class="row<?= $model->hasErrors('meta_title') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'meta_title'); ?><br />
                <?= Html::activeTextInput($model, 'meta_title'); ?><br />
                <?= Html::error($model, 'meta_title', ['class' => 'error-message']); ?>
            </div>
            <div class="row<?= $model->hasErrors('meta_description') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'meta_description'); ?><br />
                <?= Html::activeTextarea($model, 'meta_description', ['rows' => 3, 'cols' => 80]); ?><br />
                <?= Html::error($model, 'meta_description', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

    </form>

</div><!-- form -->
