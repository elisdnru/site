<?php
/** @var $this \yii\web\View */

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\models\Group;
use app\modules\blog\models\Tag;
use yii\web\View;

/** @var $model Post */
/** @var $form CActiveForm */
?>

<div class="form">

    <?php $form = Yii::app()->controller->beginWidget(
        'CActiveForm',
        [
            'id' => 'blog-post-form',
            'enableClientValidation' => true,
            'clientOptions' => [
                'validateOnSubmit' => true,
            ],
            'htmlOptions' => ['enctype' => 'multipart/form-data']
        ]
    ); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?= $form->errorSummary($model) ?>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <fieldset>
        <h4>Основное</h4>

        <div class="row">
            <?= $form->labelEx($model, 'title') ?><br />
            <?= $form->textField($model, 'title', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'title') ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'alias') ?><br />
            <?= $form->textField($model, 'alias', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'alias') ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'category_id') ?><br />
            <?= $form->dropDownList($model, 'category_id', ['' => ''] + Category::model()->getTabList()) ?>
            <br />
            <?= $form->error($model, 'category_id') ?>
        </div>

        <div class="row">
            <?= $form->labelEx($model, 'date') ?><br />
            <?= $form->textField($model, 'date', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'date') ?>
        </div>

        <div class="row">
            <?= $form->checkBox($model, 'public') ?>
            <?= $form->labelEx($model, 'public') ?><br />
            <?= $form->error($model, 'public') ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image) : ?>
            <div class="image">
                <a target="_blank" class="clightbox" href="<?= $model->imageUrl ?>"><img src="<?= $model->imageThumbUrl ?>" alt=""></a>
            </div>
            <div class="row">
                <?= $form->checkBox($model, 'del_image') ?><?= $form->labelEx($model, 'del_image') ?>
            </div>

        <?php endif; ?>

        <div class="row">
            <?= $form->labelEx($model, 'image') ?><br />
            <?= $form->fileField($model, 'image') ?><br />
            <?= $form->error($model, 'image') ?>
        </div>
        <div class="row">
            <?= $form->labelEx($model, 'image_alt') ?><br />
            <?= $form->textField($model, 'image_alt', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'image_alt') ?>
        </div>
        <div class="row">
            <?= $form->checkbox($model, 'image_show') ?>
            <?= $form->labelEx($model, 'image_show') ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Цепочка новостей</h4>
        <div class="row">
            <?= $form->labelEx($model, 'group_id') ?><br />
            <?= $form->dropDownList($model, 'group_id', [0 => ''] + Group::model()->getAssocList(true)) ?>
            <br />
            <?= $form->error($model, 'group_id') ?>
        </div>
        <div class="row">
            <?= $form->labelEx($model, 'newgroup') ?><br />
            <?= $form->textField($model, 'newgroup', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'newgroup') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'short') ?><br />
            <?= $form->textArea($model, 'short', ['rows' => 6, 'cols' => 80]) ?>
            <?= $form->error($model, 'short') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'text') ?><br />
            <?= $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80]) ?>
            <?= $form->error($model, 'text') ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?= $form->labelEx($model, 'styles') ?><br />
            <?= $form->textArea($model, 'styles', ['rows' => 10, 'cols' => 80]) ?>
            <?= $form->error($model, 'styles') ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Метки</h4>
        <div class="row">
            <?= $form->labelEx($model, 'tagsString') ?><br />
            <?= $form->textField($model, 'tagsString', ['size' => 60, 'maxlength' => 255]) ?><br />
            <?= $form->error($model, 'tagsString') ?>
        </div>
        <div class="row">
            <ul class="tags_list" id="Post_tagsVariants">
                <?php foreach (CHtml::listData(Tag::model()->findAll(['order' => 'title ASC']), 'id', 'title') as $id => $tag) : ?>
                    <li id="tag_<?= $id ?>">
                        <a class="tag" href="#"><?= CHtml::encode($tag) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </fieldset>

    <script>
    <?php ob_start(); ?>

    (function () {
        var tagsInput = document.querySelector('#Post_tagsString');
        var tagsVariants = document.querySelectorAll('#Post_tagsVariants li');

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

    <?= $this->render('//common/forms/_meta', [
        'form' => $form,
        'model' => $model,
    ]) ?>

    <div class="row buttons">
        <?= CHtml::submitButton('Сохранить') ?>
    </div>

    <?php Yii::app()->controller->endWidget(); ?>

</div><!-- form -->
