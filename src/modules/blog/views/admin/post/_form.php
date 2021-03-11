<?php

use app\components\Csrf;
use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\models\Group;
use app\modules\blog\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Post $model
 * @var ActiveForm $form
 */
?>

<div id="post-form" class="form">

    <form action="?" method="post" enctype="multipart/form-data">

        <?= Csrf::hiddenInput() ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']) ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

        <fieldset>
            <h4>Основное</h4>

            <div class="row<?= $model->hasErrors('title') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'title') ?><br />
                <?= Html::activeTextInput($model, 'title', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'title', ['class' => 'error-message']) ?>
            </div>

            <div class="row<?= $model->hasErrors('alias') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'alias') ?><br />
                <?= Html::activeTextInput($model, 'alias', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'alias', ['class' => 'error-message']) ?>
            </div>

            <div class="row<?= $model->hasErrors('category_id') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'category_id') ?><br />
                <?= Html::activeDropDownList($model, 'category_id', Category::find()->getTabList()) ?><br />
                <?= Html::error($model, 'category_id', ['class' => 'error-message']) ?>
            </div>

            <div class="row<?= $model->hasErrors('date') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'date') ?><br />
                <?= Html::activeTextInput($model, 'date') ?><br />
                <?= Html::error($model, 'date', ['class' => 'error-message']) ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'public') ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Изображение</h4>

            <?php if ($model->image) : ?>
                <div class="image">
                    <a target="_blank" href="<?= $model->getImageUrl() ?>"><img src="<?= $model->getImageThumbUrl() ?>" alt=""></a>
                </div>
                <div class="row">
                    <?= Html::activeCheckbox($model, 'delImage') ?>
                </div>
            <?php endif; ?>

            <div class="row<?= $model->hasErrors('image') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'image') ?><br />
                <?= Html::activeFileInput($model, 'image') ?><br />
                <?= Html::error($model, 'image', ['class' => 'error-message']) ?>
            </div>

            <div class="row<?= $model->hasErrors('image_alt') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'image_alt') ?><br />
                <?= Html::activeTextInput($model, 'image_alt', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'image_alt', ['class' => 'error-message']) ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'image_show') ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Цепочка новостей</h4>

            <div class="row<?= $model->hasErrors('group_id') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'group_id') ?><br />
                <?= Html::activeDropDownList($model, 'group_id', Group::find()->getAssocList(), ['prompt' => '']) ?><br />
                <?= Html::error($model, 'group_id', ['class' => 'error-message']) ?>
            </div>

            <div class="row<?= $model->hasErrors('newGroup') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'newGroup') ?><br />
                <?= Html::activeTextInput($model, 'newGroup', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'newGroup', ['class' => 'error-message']) ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('short') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'short') ?><br />
                <?= Html::activeTextarea($model, 'short', ['rows' => 6, 'cols' => 80, 'placeholder' => '<p></p>']) ?><br />
                <?= Html::error($model, 'short', ['class' => 'error-message']) ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('text') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'text') ?><br />
                <?= Html::activeTextarea($model, 'text', ['rows' => 40, 'cols' => 80, 'placeholder' => 'Markdown']) ?><br />
                <?= Html::error($model, 'text', ['class' => 'error-message']) ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('styles') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'styles') ?><br />
                <?= Html::activeTextarea($model, 'styles', ['rows' => 10, 'cols' => 80]) ?><br />
                <?= Html::error($model, 'styles', ['class' => 'error-message']) ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Метки</h4>

            <div class="row<?= $model->hasErrors('tagsString') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'tagsString') ?><br />
                <?= Html::activeTextInput($model, 'tagsString', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'tagsString', ['class' => 'error-message']) ?>
            </div>
            <div class="row">
                <ul class="tags-list" id="tags-variants">
                    <?php
                    /**
                     * @var int $id
                     * @var string $tag
                     */
                    foreach (ArrayHelper::map(Tag::find()->orderBy(['title' => SORT_ASC])->asArray()->all(), 'id', 'title') as $id => $tag) : ?>
                        <li id="tag-<?= $id ?>">
                            <a class="tag" href="#"><?= Html::encode($tag) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </fieldset>

        <script>
        <?php ob_start(); ?>

        (function () {
            var tagsInput = document.querySelector('#post-tagsstring');
            var tagsVariants = document.querySelectorAll('#tags-variants li');

            function highlightActive () {
                var tags = tagsInput.value.split(', ');
                tagsVariants.forEach(function (variant) {
                    var thisTag = variant.querySelector('.tag').innerHTML;
                    if (tags.indexOf(thisTag) !== -1) {
                        variant.classList.add('active');
                    } else {
                        variant.classList.remove('active');
                    }
                })
            }

            highlightActive()

            tagsVariants.forEach(function (variant) {
                variant.querySelector('.tag').addEventListener('click', function (e) {
                    var tags = tagsInput.value.split(', ');
                    if (!tags[0]) {
                        tags.splice(0, 1);
                    }
                    var newTag = e.target.innerHTML;
                    var index = tags.indexOf(newTag);
                    if (index === -1) {
                        tags[tags.length] = newTag;
                    } else {
                        tags.splice(index, 1);
                    }
                    tagsInput.value = tags.join(', ');
                    highlightActive()
                    e.preventDefault();
                })
            })
        })();

        <?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
        </script>

        <?= $this->render('//forms/_meta', [
            'model' => $model,
        ]) ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

    </form>

</div><!-- form -->
