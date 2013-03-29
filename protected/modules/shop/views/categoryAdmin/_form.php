<?php
/* @var $this DAdminController */
/* @var $model ShopCategory */
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
)); ?>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'title'); ?><br />
            <?php echo $form->textField($model,'title',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'alias'); ?>&nbsp;<a href="javascript:transliterate('ShopCategory_title', 'ShopCategory_alias')">Транслит наименования</a><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'type_id'); ?><br />
            <?php echo $form->dropDownList($model,'type_id',array(''=>'')+ShopType::model()->getAssocList()); ?><br />
            <?php echo $form->error($model,'type_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'parent_id'); ?><br />
            <?php echo $form->dropDownList($model,'parent_id',array(0=>'') + ($model->parent_id ? array_diff_key(ShopCategory::model()->type($model->type_id)->getTabList(), $model->type($model->type_id)->getAssocList()) : ShopCategory::model()->type($model->type_id)->getTabList())); ?><br />

            <?php echo $form->error($model,'parent_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sort'); ?><br />
            <?php echo $form->textField($model,'sort',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'sort'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?><br />
            <?php echo $form->textArea($model,'text',array('rows'=>40, 'cols'=>80, 'class'=>'tinymce')); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </fieldset>

    <?php echo $this->renderPartial('//common/forms/_meta', array(
        'form'=>$form,
        'model'=>$model,
    )); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">
    (function($){
        $('#ShopCategory_type_id').change(function(){
            var type = $(this).val();
            $('#ShopCategory_parent_id').html('<option>--- загрузка ---</option>');
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('getCategories'); ?>',
                data: {
                    'type': type,
                    '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>'
                },
                success: function(data){
                    $('#ShopCategory_parent_id').html(data);
                }
            });
        });
    })(jQuery);
</script>