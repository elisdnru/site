<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\page\forms\admin\PageForm;
use app\modules\page\models\Page;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var PageForm $model
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
            <h4>Основное</h4>

            <div class="row<?= $model->hasErrors('hidetitle') ? ' error' : ''; ?>">
                <?= Html::activeCheckbox($model, 'hidetitle'); ?><br />
                <?= Html::error($model, 'hidetitle', ['class' => 'error-message']); ?>
            </div>

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
                <?= Html::activeDropDownList($model, 'parent_id', $model->getAvailableParentList(), ['prompt' => '']); ?><br />
                <?= Html::error($model, 'parent_id', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Шаблоны отображения</h4>

            <div class="row<?= $model->hasErrors('layout') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'layout'); ?><br />
                <?= Html::activeDropDownList($model, 'layout', $model->getAvailableLayoutList()); ?><br />
                <?= Html::error($model, 'layout', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('subpages_layout') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'subpages_layout'); ?><br />
                <?= Html::activeDropDownList($model, 'subpages_layout', $model->getAvailableSubPagesLayoutList()); ?><br />
                <?= Html::error($model, 'subpages_layout', ['class' => 'error-message']); ?>
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
            <div class="row<?= $model->hasErrors('styles') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'styles'); ?><br />
                <?= Html::activeTextarea($model, 'styles', ['rows' => 10, 'cols' => 80]); ?><br />
                <?= Html::error($model, 'styles', ['class' => 'error-message']); ?>
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

        <fieldset>
            <h4>Индексация</h4>
            <div class="row<?= $model->hasErrors('system') ? ' error' : ''; ?>">
                <?= Html::activeCheckbox($model, 'system'); ?><br />
                <?= Html::error($model, 'system', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('robots') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'robots'); ?><br />
                <?= Html::activeDropDownList($model, 'robots', Page::robotsList()); ?><br />
                <?= Html::error($model, 'robots', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить'); ?>
        </div>

    </form>

</div><!-- form -->
