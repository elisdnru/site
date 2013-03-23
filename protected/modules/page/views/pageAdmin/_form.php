<?php
/* @var $this DAdminController */
/* @var $model Page */
/* @var $form CActiveForm */
?>
<?php $this->widget('tinymce.widgets.TinyMCEWidget'); ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'page-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>
        <h4>Основное</h4>
        <div class="row">
        <?php echo $form->checkBox($model,'hidetitle'); ?> <?php echo $form->labelEx($model,'hidetitle'); ?><br />
        </div>

        <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
            <div class="row">
                <?php echo $form->labelEx($model,'title'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textField($model,'title'.$suffix,array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model,'title'.$suffix); ?>
            </div>
        <?php endforeach; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'alias'); ?>&nbsp;<a href="javascript:transliterate('Page_title', 'Page_alias')">Транслит наименования</a><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>
        <hr />
        <div class="row">
            <?php echo $form->labelEx($model,'parent_id'); ?><br />
            <?php echo $form->dropDownList($model,'parent_id',array(0=>'') + ($model->parent_id ? array_diff_key(Page::model()->getTabList(), $model->getAssocList()) : Page::model()->getTabList())); ?><br />
            <?php echo $form->error($model,'parent_id'); ?>
        </div>
    </fieldset>

    <fieldset>
        <h4>Шаблоны отображения</h4>
        <div class="row">
            <?php echo $form->labelEx($model,'layout_id'); ?><br />
            <?php echo $form->dropDownList($model,'layout_id', array(0=>'По умолчанию') + PageLayout::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'layout_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'layout_subpages_id'); ?><br />
            <?php echo $form->dropDownList($model,'layout_subpages_id', array(0=>'Не отображать (по умолчанию)') + PageLayoutSubpages::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'layout_subpages_id'); ?>
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
    </fieldset>

    <fieldset>
        <h4>Приложенные файлы</h4>

        <?php foreach ($model->files as $file) : ?>
        <?php if ($file->file): ?>
            <p id="file_<?php echo $file->id; ?>">
                <img src="/core/images/admin/fileicon.jpg" alt="" /> <a target="_blank" href="<?php echo Yii::app()->request->baseUrl . '/' . PageFile::FILE_PATH . '/' .  $file->file; ?>" ><?php echo $file->title; ?></a>
                <a class="ajax_del" data-del="file_<?php echo $file->id; ?>" title="Удалить файл" href="<?php echo $this->createUrl('admin/pages/filedel', array('id'=>$file->id));?>"><img src="/core/images/admin/del.png" alt="Удалить" /></a>
            </p>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="row">
            <?php echo $form->labelEx($model,'file'); ?><br />
            <?php for ($i = 1; $i < PageFile::FILES_LIMIT + 1; $i++): ?>
            <?php echo $form->fileField($model,'file_'.$i); ?><br />
            <?php endfor; ?>
        </div>
    </fieldset>

    <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <fieldset class="editor">
            <div class="row">
                <?php echo $form->labelEx($model,'text'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textArea($model,'text'.$suffix,array('rows'=>40, 'cols'=>80, 'class'=>'tinymce')); ?>
                <?php echo $form->error($model,'text'.$suffix); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <p>&nbsp;</p>

    <fieldset>
        <h4>Мета-информация</h4>
        <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <div class="row">
            <?php echo $form->labelEx($model,'pagetitle'); ?> <?php echo $lang; ?><br />
            <?php echo $form->textField($model,'pagetitle' . $suffix,array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'pagetitle' . $suffix); ?>
        </div>
        <?php endforeach; ?>

        <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <div class="row">
            <?php echo $form->labelEx($model,'description'); ?> <?php echo $lang; ?><br />
            <?php echo $form->textArea($model,'description' . $suffix,array('rows'=>3, 'cols'=>80)); ?><br />
            <?php echo $form->error($model,'description' . $suffix); ?>
        </div>
        <?php endforeach; ?>

        <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
        <div class="row">
            <?php echo $form->labelEx($model,'keywords'); ?> <?php echo $lang; ?><br />
            <?php echo $form->textField($model,'keywords' . $suffix,array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'keywords' . $suffix); ?>
        </div>
        <?php endforeach; ?>
    </fieldset>

    <?php $this->endWidget(); ?>

</div><!-- form -->