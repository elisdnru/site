<?php
/* @var $this AdminController */

use app\modules\blog\extensions\multicomplete\MultiComplete;
use app\modules\blog\models\BlogCategory;
use app\modules\blog\models\BlogPost;
use app\modules\blog\models\BlogPostGroup;
use app\modules\blog\models\BlogTag;
use app\components\AdminController;

/* @var $model BlogPost */
/* @var $form CActiveForm */
?>

<?php
$cs = Yii::app()->getClientScript();
$url = CHtml::asset(Yii::getPathOfAlias('application.modules.blog.assets'));
$cs->registerCoreScript('jquery');
$cs->registerCssFile($url . '/tags.css');
?>

<?php $this->widget(\app\components\tinymce\widgets\TinyMCEWidget::class); ?>

<div class="form">

    <?php $form = $this->beginWidget(
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

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>
        <h4>Основное</h4>

        <div class="row">
            <?php echo $form->labelEx($model, 'title'); ?><br />
            <?php echo $form->textField($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'alias'); ?>
            &nbsp;<a href="javascript:transliterate('BlogPost_title', 'BlogPost_alias')">Транслит наименования</a><br />
            <?php echo $form->textField($model, 'alias', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'category_id'); ?><br />
            <?php echo $form->dropDownList($model, 'category_id', ['' => ''] + BlogCategory::model()->getTabList()); ?>
            <br />
            <?php echo $form->error($model, 'category_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'date'); ?><br />
            <?php echo $form->textField($model, 'date', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'date'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model, 'public'); ?>
            <?php echo $form->labelEx($model, 'public'); ?><br />
            <?php echo $form->error($model, 'public'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image) : ?>
            <div class="image">
                <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt="" /></a>
            </div>
            <div class="row">
                <?php echo $form->checkBox($model, 'del_image'); ?><?php echo $form->labelEx($model, 'del_image'); ?>
            </div>

        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'image'); ?><br />
            <?php echo $form->fileField($model, 'image'); ?><br />
            <?php echo $form->error($model, 'image'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'image_alt'); ?><br />
            <?php echo $form->textField($model, 'image_alt', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'image_alt'); ?>
        </div>
        <div class="row">
            <?php echo $form->checkbox($model, 'image_show'); ?>
            <?php echo $form->labelEx($model, 'image_show'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Цепочка новостей</h4>
        <div class="row">
            <?php echo $form->labelEx($model, 'group_id'); ?><br />
            <?php echo $form->dropDownList($model, 'group_id', [0 => ''] + BlogPostGroup::model()->getAssocList(true)); ?>
            <br />
            <?php echo $form->error($model, 'group_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'newgroup'); ?><br />
            <?php echo $form->textField($model, 'newgroup', ['size' => 60, 'maxlength' => 255]); ?><br />
            <?php echo $form->error($model, 'newgroup'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model, 'short'); ?><br />
            <?php echo $form->textArea($model, 'short', ['rows' => 16, 'cols' => 80, 'class' => 'tinymce']); ?>
            <?php echo $form->error($model, 'short'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model, 'text'); ?><br />
            <?php echo $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80]); ?>
            <?php echo $form->error($model, 'text'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Метки</h4>
        <div class="row">
            <?php $this->widget(MultiComplete::class, [
                'model' => $model,
                'attribute' => 'tagsString',
                'splitter' => ',',
                'sourceUrl' => $this->createUrl('/blog/postAdmin/autocompletetags'),
                'options' => [
                    'minLength' => '1',
                ]
            ]); ?>
        </div>
        <div class="row">
            <ul class="tags_list" id="BlogPost_tagsVariants">
                <?php foreach (CHtml::listData(BlogTag::model()->findAll(['order' => 'title ASC']), 'id', 'title') as $id => $tag) : ?>
                    <li id="tag_<?php echo $id; ?>">
                        <a class="tag" href="#"><?php echo CHtml::encode($tag); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </fieldset>

    <script>
    <?php ob_start(); ?>

    jQuery(function ($) {
        var tagsInput = $('#BlogPost_tagsString')
        var tagsVariants = $('#BlogPost_tagsVariants li')

        function highlightActive () {
            var tags = tagsInput.val().split(', ')
            tagsVariants.each(function () {
                var variant = $(this)
                var thisTag = variant.find('.tag').text()
                if (tags.indexOf(thisTag) !== -1) {
                    variant.addClass('active')
                } else {
                    variant.removeClass('active')
                }
            })
        }

        highlightActive()

        tagsVariants.find('.tag').click(function (e) {
            var tags = tagsInput.val().split(', ')
            if (!tags[0]) {
                tags.splice(0, 1)
            }
            var newTag = $(this).text()
            var index = tags.indexOf(newTag)
            if (index === -1) {
                tags[tags.length] = newTag
            } else {
                tags.splice(index, 1)
            }
            tagsInput.val(tags.join(', '))
            highlightActive()
            e.stopPropagation()
            return false
        })
    })

    <?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
    </script>

    <?php echo $this->renderPartial('//common/forms/_meta', [
        'form' => $form,
        'model' => $model,
    ]); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
