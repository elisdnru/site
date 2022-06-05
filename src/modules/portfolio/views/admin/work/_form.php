<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Work $model
 * @var ActiveForm $form
 */
?>

<div class="form">
    <form action="?" method="post" enctype="multipart/form-data">

        <?= Csrf::hiddenInput(); ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'error-summary']); ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

        <fieldset>
            <h4>Основное</h4>

            <div class="row<?= $model->hasErrors('title') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'title'); ?><br />
                <?= Html::activeTextInput($model, 'title'); ?><br />
                <?= Html::error($model, 'title', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('slug') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'slug'); ?><br />
                <?= Html::activeTextInput($model, 'slug'); ?><br />
                <?= Html::error($model, 'slug', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('category_id') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'category_id'); ?><br />
                <?= Html::activeDropDownList($model, 'category_id', Category::find()->getTabList()); ?><br />
                <?= Html::error($model, 'category_id', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('date') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'date'); ?><br />
                <?= Html::activeTextInput($model, 'date'); ?><br />
                <?= Html::error($model, 'date', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('sort') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'sort'); ?><br />
                <?= Html::activeTextInput($model, 'sort'); ?><br />
                <?= Html::error($model, 'sort', ['class' => 'error-message']); ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'public'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Изображение</h4>

            <?php if ($model->image) : ?>
                <div class="image">
                    <a target="_blank" href="<?= $model->getImageUrl(); ?>"><img src="<?= $model->getImageThumbUrl(250, 0); ?>" alt=""></a>
                </div>
                <div class="row">
                    <?= Html::activeCheckbox($model, 'delImage'); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="row<?= $model->hasErrors('image') ? ' error' : ''; ?>">
                    <?= Html::activeLabel($model, 'image'); ?><br />
                    <?= Html::activeFileInput($model, 'image'); ?><br />
                    <?= Html::error($model, 'image', ['class' => 'error-message']); ?>
                </div>
            </div>
            <div class="row">
                <?= Html::activeCheckbox($model, 'image_show'); ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('short') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'short'); ?><br />
                <?= Html::activeTextarea($model, 'short', ['rows' => 6, 'cols' => 80]); ?><br />
                <?= Html::error($model, 'short', ['class' => 'error-message']); ?>
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
