<?php
/* @var $this DAdminController */
/* @var $model ShopProduct */
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
        'htmlOptions'=>array('enctype'=>'multipart/form-data')
    )
); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>
    <br />
    <?php echo $form->errorSummary($model); ?>

    <div style="width:49%; float:left;">
        <fieldset>
            <h4>Основное</h4>

            <div class="row">
                <?php echo $form->labelEx($model,'artikul'); ?><br />
                <?php echo $form->textField($model,'artikul',array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model,'artikul'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'title'); ?><br />
                <?php echo $form->textField($model,'title',array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model,'title'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'price'); ?><br />
                <?php echo $form->textField($model,'price',array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model,'price'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'count'); ?><br />
                <?php echo $form->textField($model,'count',array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model,'count'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Каталог</h4>
            <div class="row">
                <?php echo $form->labelEx($model,'priority'); ?><br />
                <?php echo $form->textField($model,'priority',array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model,'priority'); ?>
            </div>

            <div class="row">
                <?php echo $form->checkBox($model,'public'); ?>
                <?php echo $form->labelEx($model,'public'); ?><br />
                <?php echo $form->error($model,'public'); ?>
            </div>

            <div class="row">
                <?php echo $form->checkBox($model,'popular'); ?>
                <?php echo $form->labelEx($model,'popular'); ?><br />
                <?php echo $form->error($model,'popular'); ?>
            </div>

            <div class="row">
                <?php echo $form->checkBox($model,'inhome'); ?>
                <?php echo $form->labelEx($model,'inhome'); ?><br />
                <?php echo $form->error($model,'inhome'); ?>
            </div>

            <div class="row">
                <?php echo $form->checkBox($model,'sale'); ?>
                <?php echo $form->labelEx($model,'sale'); ?><br />
                <?php echo $form->error($model,'sale'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Производитель</h4>
            <div class="row">
                <?php echo $form->labelEx($model,'brand_id'); ?><br />
                <?php echo $form->dropDownList($model,'brand_id',array(''=>'') + ShopBrand::model()->getAssocList()); ?><br />
                <?php echo $form->error($model,'brand_id'); ?>
            </div>
        </fieldset>

        <?php if (Yii::app()->moduleManager->active('rubrikator')): ?>
            <?php Yii::import('application.modules.rubrikator.models.*'); ?>
            <fieldset>
                <h4>Рубрикатор</h4>
                <?php echo $form->labelEx($model,'rubrika_id'); ?><br />
                <?php echo $form->dropDownList($model,'rubrika_id',array(''=>'') + RubrikatorArticle::model()->getAssocList()); ?><br />
                <?php echo $form->error($model,'rubrika_id'); ?>
            </fieldset>
        <?php endif; ?>

    </div>

    <div style="width:49%; float:right;">

        <fieldset>
            <h4>Тип</h4>
            <div class="row">
                <?php echo $form->labelEx($model,'type_id'); ?><br />
                <?php echo $form->dropDownList($model,'type_id',array(''=>'') + ShopType::model()->getAssocList()); ?><br />
                <?php echo $form->error($model,'type_id'); ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Главная категория</h4>
            <div class="row">
                <?php echo $form->labelEx($model,'category_id'); ?><br />
                <?php echo $form->dropDownList($model,'category_id',array(''=>'') + ShopCategory::model()->type($model->type_id)->getTabList()); ?><br />
                <?php echo $form->error($model,'category_id'); ?>
            </div>
        </fieldset>

        <?php if (ShopColor::model()->count()): ?>
        <fieldset>
            <h4>Цвета</h4>
            <div style="max-height:370px; overflow:auto;">
                <?php echo $form->checkBoxList($model,'colorsArray', ShopColor::model()->getAssocList()); ?>
            </div>
        </fieldset>
        <?php endif; ?>

        <?php if (ShopSize::model()->count()): ?>
        <fieldset>
            <h4>Размеры</h4>
            <div style="max-height:370px; overflow:auto;">
                <?php echo $form->checkBoxList($model,'sizesArray', ShopSize::model()->getAssocList()); ?>
            </div>
        </fieldset>
        <?php endif; ?>

        <fieldset>
            <h4>Атрибуты</h4>
            <div id="attrFields">
                <?php foreach($model->otherAttributes as $attribute): ?>
                <div class="row">
                    <label><?php echo $attribute->title; ?></label>
                    <?php echo CHtml::textField(get_class($model) . '[otherAttributesAssoc][' . $attribute->alias . ']', $attribute->value, array('maxlength'=>255)); ?>
                </div>
                <?php endforeach; ?>
            </div>
        </fieldset>

        <fieldset>
            <h4>Дополнительные категории</h4>
            <div style="max-height:370px; overflow:auto;">
                <?php echo $form->checkBoxList($model,'otherCategoriesArray', ShopCategory::model()->getTabList()); ?>
            </div>
        </fieldset>

    </div>

    <div class="clear"></div>

    <?php if ($model->isMainProduct()): ?>

    <fieldset>
        <?php foreach ($model->images as $image) : ?>
        <?php if ($image->file): ?>

            <span id="image_<?php echo $image->id; ?>">
                <a class="lightbox" rel="group" href="<?php echo $image->url; ?>"><img src="<?php echo $image->getThumbUrl(150, 150); ?>" alt="" /></a>
                <a class="ajax_post" title="Сделать главным" style="margin-left:-40px;" href="<?php echo $this->createUrl('imagemain', array('id'=>$image->id));?>"><img src="/core/images/admin/yes.png" alt="Удалить" /></a>
                <a class="ajax_del" data-del="image_<?php echo $image->id; ?>" title="Удалить изображение" style="margin-left:0;" href="<?php echo $this->createUrl('imagedel', array('id'=>$image->id));?>"><img src="/core/images/admin/del.png" alt="Удалить" /></a>
            </span>

            <?php endif; ?>
        <?php endforeach; ?>
        <div class="row">
            <?php echo $form->labelEx($model,'image'); ?><br />
            <?php echo $form->fileField($model,'image_1'); ?><br />
            <?php echo $form->fileField($model,'image_2'); ?><br />
            <?php echo $form->fileField($model,'image_3'); ?><br />
            <?php echo $form->fileField($model,'image_4'); ?><br />
            <?php echo $form->fileField($model,'image_5'); ?>
        </div>
    </fieldset>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'short'); ?><br />
            <?php echo $form->textField($model,'short',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'short'); ?>
        </div>
    </fieldset>

    <fieldset class="editor">
        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?><br />
            <?php echo $form->textArea($model,'text',array('rows'=>10, 'cols'=>80, 'class'=>'tinymce')); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </fieldset>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'pagetitle'); ?><br />
            <?php echo $form->textField($model,'pagetitle',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'pagetitle'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'description'); ?><br />
            <?php echo $form->textArea($model,'description',array('rows'=>3, 'cols'=>80)); ?><br />
            <?php echo $form->error($model,'description'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'keywords'); ?><br />
            <?php echo $form->textField($model,'keywords',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'keywords'); ?>
        </div>
    </fieldset>

    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    (function($){
        $('#ShopProduct_type_id').change(function(){
            var type = $(this).val();

            $('#ShopProduct_category_id').html('<option>--- загрузка ---</option>');
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getCategories'); ?>',
                data: {
                    'type': type,
                    'id': '<?php echo $model->id; ?>',
                    '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>'
                },
                success: function(data){
                    $('#ShopProduct_category_id').html(data);
                },
                error:function(XHR) {
                    alert(XHR.responseText);
                }

            });

            $('#attrFields').html('--- загрузка ---');
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getAttributes'); ?>',
                data: {
                    'type': type,
                    'id': '<?php echo $model->id; ?>',
                    '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>'
                },
                success: function(data){
                    $('#attrFields').html(data);
                },
                error:function(XHR) {
                    alert(XHR.responseText);
                }
            });
        });
    })(jQuery);
</script>

