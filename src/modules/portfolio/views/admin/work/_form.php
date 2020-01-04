<?php
/** @var $this \yii\web\View */

use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use yii\helpers\Html;

/** @var $model Work */
/** @var $form CActiveForm */
?>

<div class="form">
    <form action="?" method="post" enctype="multipart/form-data">

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']) ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

        <fieldset>
            <h4>Основное</h4>

            <div class="row<?= $model->hasErrors('title') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'title') ?><br />
                <?= Html::activeTextInput($model, 'title') ?><br />
                <?= Html::error($model, 'title', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('alias') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'alias') ?><br />
                <?= Html::activeTextInput($model, 'alias') ?><br />
                <?= Html::error($model, 'alias', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('category_id') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'category_id') ?><br />
                <?= Html::activeDropDownList($model, 'category_id', Category::find()->getTabList()) ?><br />
                <?= Html::error($model, 'category_id', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('date') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'date') ?><br />
                <?= Html::activeTextInput($model, 'date') ?><br />
                <?= Html::error($model, 'date', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'public') ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Изображение</h4>

            <?php if ($model->image) : ?>
                <div class="image">
                    <a target="_blank" class="clightbox" href="<?= $model->getImageUrl() ?>"><img src="<?= $model->imageThumbUrl ?>" alt=""></a>
                </div>
                <div class="row">
                    <?= Html::activeCheckbox($model, 'del_image') ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="row<?= $model->hasErrors('image') ? ' error' : '' ?>">
                    <?= Html::activeLabel($model, 'image') ?><br />
                    <?= Html::activeFileInput($model, 'image') ?><br />
                    <?= Html::error($model, 'image', ['class' => 'errorMessage']) ?>
                </div>
            </div>
            <div class="row">
                <?= Html::activeCheckbox($model, 'image_show') ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('short') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'short') ?><br />
                <?= Html::activeTextarea($model, 'short', ['rows' => 6, 'cols' => 80]) ?><br />
                <?= Html::error($model, 'short', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('text') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'text') ?><br />
                <?= Html::activeTextarea($model, 'text', ['rows' => 40, 'cols' => 80]) ?><br />
                <?= Html::error($model, 'text', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <?= $this->render('//common/forms/v2/_meta', ['model' => $model]) ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

    </form>

</div><!-- form -->
