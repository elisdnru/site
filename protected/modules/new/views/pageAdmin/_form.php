<?php
/* @var $this DAdminController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<?php $this->widget('tinymce.widgets.TinyMCEWidget'); ?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm',
        array(
            'id'=>'new-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )
    ); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>
        <h4>Основное</h4>

        <div class="row">
            <?php echo $form->labelEx($model,'page_id'); ?><br />
            <?php echo $form->dropDownList($model,'page_id',array(''=>'') + Page::model()->getTabList($this->user->accessPagesArray)); ?><br />
            <?php echo $form->error($model,'page_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'list_layout'); ?><br />
            <?php echo $form->dropDownList($model,'list_layout',  NewsPage::model()->getListLayouts()); ?><br />
            <?php echo $form->error($model,'list_layout'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'show_layout'); ?><br />
            <?php echo $form->dropDownList($model,'show_layout', NewsPage::model()->getShowLayouts()); ?><br />
            <?php echo $form->error($model,'show_layout'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'show_view'); ?><br />
            <?php echo $form->dropDownList($model,'show_view', NewsPage::model()->getShowViews()); ?><br />
            <?php echo $form->error($model,'show_view'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->