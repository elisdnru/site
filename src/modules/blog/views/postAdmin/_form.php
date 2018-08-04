<?php
/* @var $this DAdminController */
/* @var $model BlogPost */
/* @var $form CActiveForm */
?>

<?php
$cs = Yii::app()->getClientScript();
$url = CHtml::asset(Yii::getPathOfAlias('application.modules.blog.assets'));
$cs->registerCssFile($url . '/tags.css');
?>

<?php $this->widget('tinymce.widgets.TinyMCEWidget'); ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm',
    array(
        'id'=>'blog-post-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array('enctype'=>'multipart/form-data')
    )
); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>
        <h4>Основное</h4>

        <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
            <div class="row">
                <?php echo $form->labelEx($model,'title'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textField($model, 'title' . $suffix, array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model, 'title' . $suffix); ?>
            </div>
        <?php endforeach; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'alias'); ?>&nbsp;<a href="javascript:transliterate('BlogPost_title', 'BlogPost_alias')">Транслит наименования</a><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'category_id'); ?><br />
            <?php echo $form->dropDownList($model,'category_id',array(''=>'') + BlogCategory::model()->getTabList()); ?><br />
            <?php echo $form->error($model,'category_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'date'); ?><br />
            <?php echo $form->textField($model,'date',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'date'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'public'); ?>
            <?php echo $form->labelEx($model,'public'); ?><br />
            <?php echo $form->error($model,'public'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image): ?>

        <div class="image">
            <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt="" /></a>
        </div>
        <div class="row">
            <?php echo $form->checkBox($model,'del_image'); ?> <?php echo $form->labelEx($model,'del_image'); ?>
        </div>

        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'image'); ?><br />
            <?php echo $form->fileField($model,'image'); ?><br />
            <?php echo $form->error($model,'image'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'image_alt'); ?><br />
            <?php echo $form->textField($model,'image_alt',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'image_alt'); ?>
        </div>
        <div class="row">
            <?php echo $form->checkbox($model,'image_show'); ?>
            <?php echo $form->labelEx($model,'image_show'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Фотогалерея</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'gallery_id'); ?><br />
            <?php echo $form->dropDownList($model,'gallery_id',array('0'=>'') + NewsGallery::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'gallery_id'); ?>
            <a class="floatright" href="<?php echo $this->createUrl('/newsgallery/galleryAdmin/create'); ?>">Создать новую галерею</a>
        </div>
    </fieldset>

    <fieldset>
        <h4>Цепочка новостей</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'group_id'); ?><br />
            <?php echo $form->dropDownList($model,'group_id',array(0=>'') + BlogPostGroup::model()->getAssocList(true)); ?><br />
            <?php echo $form->error($model,'group_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'newgroup'); ?><br />
            <?php echo $form->textField($model,'newgroup',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'newgroup'); ?>
        </div>
    </fieldset>

    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <fieldset class="editor">
            <div class="row">
                <?php echo $form->labelEx($model,'short'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textArea($model, 'short' . $suffix, array('rows'=>16, 'cols'=>80, 'class'=>'tinymce')); ?>
                <?php echo $form->error($model, 'short' . $suffix); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <fieldset class="editor">
            <div class="row">
                <?php echo $form->labelEx($model,'text'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textArea($model, 'text' . $suffix, array('rows'=>40, 'cols'=>80)); ?>
                <?php echo $form->error($model, 'text' . $suffix); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <fieldset>
        <h4>Метки</h4>
        <div class="row">
            <?php $this->widget('blog.extensions.multicomplete.MultiComplete', array(
            'model'=>$model,
            'attribute'=>'tagsString',
            'splitter'=>',',
            'sourceUrl'=>$this->createUrl('/blog/postAdmin/autocompletetags'),
            'options'=>array(
                'minLength'=>'1',
            )
        )); ?>
        </div>
        <div class="row">
            <ul class="tags_list" id="BlogPost_tagsVariants">
                <?php foreach(CHtml::listData(BlogTag::model()->findAll(array('order'=>'title ASC')), 'id', 'title') as $id=>$tag): ?>
                    <li id="tag_<?php echo $id; ?>">
                        <a class="tag" href="#"><?php echo CHtml::encode($tag); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </fieldset>

    <script type="text/javascript">
        (function ($){
            var tagsInput = $('#BlogPost_tagsString');
            var tagsVariants = $('#BlogPost_tagsVariants li');

            function highlightActive(){
                var tags = tagsInput.val().split(', ');
                tagsVariants.each(function(){
                    var variant = $(this);
                    var thisTag = variant.find('.tag').text();
                    if (tags.indexOf(thisTag) != -1){
                        variant.addClass('active');
                    } else {
                        variant.removeClass('active');
                    }
                });
            }

            highlightActive();

            tagsVariants.find('.tag').click(function(e){
                var tags = tagsInput.val().split(', ');
                if (!tags[0]){
                    tags.splice(0,1);
                }
                var newTag = $(this).text();
                var index = tags.indexOf(newTag);
                if (index == -1){
                    tags[tags.length] = newTag;
                } else {
                    tags.splice(index, 1);
                }
                tagsInput.val(tags.join(', '));
                highlightActive();
                e.stopPropagation();
                return false;
            });
        })(jQuery);
    </script>

    <?php echo $this->renderPartial('//common/forms/_lang_meta', array(
        'form'=>$form,
        'model'=>$model,
    )); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->