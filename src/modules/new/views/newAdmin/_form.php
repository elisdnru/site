<?php
/* @var $this DAdminController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<?php $this->widget('tinymce.widgets.TinyMCEWidget'); ?>

<div class="form">

    <?php $form = $this->beginWidget(
        'CActiveForm',
        [
            'id' => 'new-form',
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
            <?php echo $form->labelEx($model, 'title'); ?><br/>
            <?php echo $form->textField($model, 'title', ['size' => 60, 'maxlength' => 255]); ?><br/>
            <?php echo $form->error($model, 'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'alias'); ?>
            &nbsp;<a href="javascript:transliterate('News_title', 'News_alias')">Транслит наименования</a><br/>
            <?php echo $form->textField($model, 'alias', ['size' => 60, 'maxlength' => 255]); ?><br/>
            <?php echo $form->error($model, 'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'page_id'); ?><br/>
            <?php echo $form->dropDownList($model, 'page_id', ['' => ''] + NewsPage::model()->getPages($this->user->accessPagesArray)); ?>
            <br/>
            <?php echo $form->error($model, 'page_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'date'); ?><br/>
            <?php echo $form->textField($model, 'date', ['size' => 60, 'maxlength' => 255]); ?><br/>
            <?php echo $form->error($model, 'date'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model, 'public'); ?>
            <?php echo $form->labelEx($model, 'public'); ?><br/>
            <?php echo $form->error($model, 'public'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model, 'inhome'); ?>
            <?php echo $form->labelEx($model, 'inhome'); ?><br/>
            <?php echo $form->error($model, 'inhome'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Изображение</h4>

        <?php if ($model->image) : ?>
            <div class="image">
                <a target="_blank" class="clightbox" href="<?php echo $model->imageUrl; ?>"><img src="<?php echo $model->imageThumbUrl; ?>" alt=""/></a>
            </div>
            <div class="row">
                <?php echo $form->checkBox($model, 'del_image'); ?><?php echo $form->labelEx($model, 'del_image'); ?>
            </div>

        <?php endif; ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'image'); ?><br/>
            <?php echo $form->fileField($model, 'image'); ?><br/>
            <?php echo $form->error($model, 'image'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'image_alt'); ?><br/>
            <?php echo $form->textField($model, 'image_alt', ['size' => 60, 'maxlength' => 255]); ?><br/>
            <?php echo $form->error($model, 'image_alt'); ?>
        </div>
        <div class="row">
            <?php echo $form->checkbox($model, 'image_show'); ?>
            <?php echo $form->labelEx($model, 'image_show'); ?>
        </div>

    </fieldset>

    <fieldset>
        <h4>Приложенные файлы</h4>

        <?php foreach ($model->files as $file) : ?>
            <?php if ($file->file) : ?>
                <p id="file_<?php echo $file->id; ?>">
                    <img src="/images/admin/fileicon.jpg" alt=""/>
                    <a target="_blank" href="<?php echo Yii::app()->request->baseUrl . '/' . NewsFile::FILE_PATH . '/' . $file->file; ?>"><?php echo $file->title; ?></a>
                    <a class="ajax_del" data-del="file_<?php echo $file->id; ?>" title="Удалить файл" href="<?php echo $this->createUrl('admin/news/filedel', ['id' => $file->id]); ?>"><img src="/images/admin/del.png" alt="Удалить"/></a>
                </p>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'files'); ?><br/>
            <?php for ($i = 1; $i < NewsFile::FILES_LIMIT + 1; $i++) : ?>
                <?php echo $form->fileField($model, 'file_' . $i); ?><br/>
            <?php endfor; ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Цепочка новостей</h4>
        <div class="row">
            <?php echo $form->labelEx($model, 'group_id'); ?><br/>
            <?php echo $form->dropDownList($model, 'group_id', [0 => ''] + NewsGroup::model()->getAssocList(true)); ?>
            <br/>
            <?php echo $form->error($model, 'group_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'newgroup'); ?><br/>
            <?php echo $form->textField($model, 'newgroup', ['size' => 60, 'maxlength' => 255]); ?><br/>
            <?php echo $form->error($model, 'newgroup'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model, 'short'); ?><br/>
            <?php echo $form->textArea($model, 'short', ['rows' => 16, 'cols' => 80, 'class' => 'tinymce']); ?>
            <?php echo $form->error($model, 'short'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model, 'text'); ?><br/>
            <?php echo $form->textArea($model, 'text', ['rows' => 40, 'cols' => 80, 'class' => 'tinymce']); ?>
            <?php echo $form->error($model, 'text'); ?>
        </div>
    </fieldset>

    <?php echo $this->renderPartial('//common/forms/_meta', [
        'form' => $form,
        'model' => $model,
    ]); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
