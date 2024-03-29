<?php declare(strict_types=1);

use app\components\Csrf;
use app\modules\blog\forms\admin\PostForm;
use app\modules\blog\models\Post;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var PostForm $model
 * @var Post|null $post
 * @var ActiveForm $form
 */
?>

<div id="post-form" class="form">

    <form action="?" method="post" enctype="multipart/form-data">

        <?= Csrf::hiddenInput(); ?>

        <?= Html::errorSummary($model, ['class' => 'error-summary']); ?>

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

            <div class="row<?= $model->hasErrors('slug') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'slug'); ?><br />
                <?= Html::activeTextInput($model, 'slug', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'slug', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('category_id') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'category_id'); ?><br />
                <?= Html::activeDropDownList($model, 'category_id', $model->getAvailableCategoriesList()); ?><br />
                <?= Html::error($model, 'category_id', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('date') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'date'); ?><br />
                <?= Html::activeTextInput($model, 'date'); ?><br />
                <?= Html::error($model, 'date', ['class' => 'error-message']); ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'public'); ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'promoted'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Изображение</h4>

            <?php if ($post !== null && $post->image): ?>
                <div class="image">
                    <a target="_blank" href="<?= $post->getImageUrl(); ?>"><img src="<?= $post->getImageThumbUrl(250, 0); ?>" alt=""></a>
                </div>
                <div class="row">
                    <?= Html::activeCheckbox($model, 'del_image'); ?>
                </div>
            <?php endif; ?>

            <div class="row<?= $model->hasErrors('image') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'image'); ?><br />
                <?= Html::activeFileInput($model, 'image'); ?><br />
                <?= Html::error($model, 'image', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('image_alt') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'image_alt'); ?><br />
                <?= Html::activeTextInput($model, 'image_alt', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'image_alt', ['class' => 'error-message']); ?>
            </div>

            <div class="row">
                <?= Html::activeCheckbox($model, 'image_show'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Цепочка новостей</h4>

            <div class="row<?= $model->hasErrors('group_id') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'group_id'); ?><br />
                <?= Html::activeDropDownList($model, 'group_id', $model->getAvailableGroupsList(), ['prompt' => '']); ?><br />
                <?= Html::error($model, 'group_id', ['class' => 'error-message']); ?>
            </div>

            <div class="row<?= $model->hasErrors('new_group') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'new_group'); ?><br />
                <?= Html::activeTextInput($model, 'new_group', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'new_group', ['class' => 'error-message']); ?>
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
                <?= Html::activeTextarea($model, 'text', ['rows' => 40, 'cols' => 80, 'placeholder' => 'Markdown']); ?><br />
                <?= Html::error($model, 'text', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <fieldset class="editor">
            <div class="row<?= $model->hasErrors('styles') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'styles'); ?><br />
                <?= Html::activeTextarea($model, 'styles', ['rows' => 10, 'cols' => 80]); ?><br />
                <?= Html::error($model, 'styles', ['class' => 'error-message']); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Метки</h4>

            <div class="row<?= $model->hasErrors('tags') ? ' error' : ''; ?>">
                <?= Html::activeLabel($model, 'tags'); ?><br />
                <?= Html::activeTextInput($model, 'tags', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($model, 'tags', ['class' => 'error-message']); ?>
            </div>
            <div class="row">
                <ul class="tags-list" id="tags-variants">
                    <?php foreach ($model->getAvailableTagsList() as $id => $name): ?>
                        <li id="tag-<?= $id; ?>">
                            <a class="tag" href="#"><?= Html::encode($name); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </fieldset>

        <script>
        <?php ob_start(); ?>

        (function () {
            const tagsInput = document.querySelector('#postform-tags');
            const tagsVariants = document.querySelectorAll('#tags-variants li');

            function highlightActive () {
                const tags = tagsInput.value.split(', ');
                tagsVariants.forEach(function (variant) {
                    const thisTag = variant.querySelector('.tag').innerHTML;
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
                    const tags = tagsInput.value.split(", ");
                    if (!tags[0]) {
                        tags.splice(0, 1);
                    }
                    const newTag = e.target.innerHTML;
                    const index = tags.indexOf(newTag);
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
