<?php
/* @var $this DAdminController */
/* @var $model Menu */
/* @var $form CActiveForm */
?>

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

        <?php foreach (DMultilangHelper::suffixList() as $suffix => $lang) : ?>
            <div class="row">
                <?php echo $form->labelEx($model,'title'); ?> <?php echo $lang; ?><br />
                <?php echo $form->textField($model,'title'.$suffix,array('size'=>60, 'maxlength'=>255)); ?><br />
                <?php echo $form->error($model,'title'.$suffix); ?>
            </div>
        <?php endforeach; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'parent_id'); ?><br />
            <?php echo $form->dropDownList($model,'parent_id',array(0=>'') + ($model->parent_id ? array_diff_key(Menu::model()->getTabList(), $model->getAssocList()) : Menu::model()->getTabList())); ?><br />
            <?php echo $form->error($model,'parent_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sort'); ?><br />
            <?php echo $form->textField($model,'sort',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'sort'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'visible'); ?>
            <?php echo $form->labelEx($model,'visible'); ?><br />
            <?php echo $form->error($model,'visible'); ?>
        </div>
    </fieldset>


    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'link'); ?><br />
            <?php echo $form->textField($model,'link',array('size'=>60, 'maxlength'=>255, 'class'=>'m_urlfield')); ?><br />
            <?php echo $form->error($model,'link'); ?>
        </div>
        <hr />
        <div class="row">
            <label>Ссылка на страницу</label><br />
            <?php echo CHtml::dropDownList('sss', '/'.$model->link, Array(''=>'') + Page::model()->getUrlList(), array('class'=>'m_selector')); ?><br />
        </div>
        <?php if (Yii::app()->moduleManager->active('shop')): ?>
        <?php Yii::import('shop.models.*'); ?>
        <div class="row">
            <label>Ссылка на тип товара</label><br />
            <?php echo CHtml::dropDownList('sss', '/'.$model->link, Array(''=>'') + ShopType::model()->getUrlList(), array('class'=>'m_selector')); ?><br />
        </div>
        <div class="row">
            <label>Ссылка на категорию магазина</label><br />
            <?php echo CHtml::dropDownList('sss', '/'.$model->link, Array(''=>'') + ShopCategory::model()->getUrlList(), array('class'=>'m_selector')); ?><br />
        </div>
        <?php endif; ?>

    </fieldset>

    <fieldset>
        <div class="row">
            <?php echo $form->labelEx($model,'alias'); ?><br />
            <?php echo $form->textField($model,'alias',array('size'=>60, 'maxlength'=>255)); ?><br />
            <?php echo $form->error($model,'alias'); ?>
        </div>
    </fieldset>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

    <script type="text/javascript">
        /*<![CDATA[*/
        if (!$('.m_urlfield').val()) $('.m_urlfield').val('#');
        $('.m_selector').change(function(){
            var val = $(this).val()
            if (val == ''){
                $('.m_urlfield').val('#');
            } else {
                $('.m_urlfield').val($(this).val());
            }
            $('.m_selector').val('');
            $(this).val(val);
        });
        /*]]>*/
    </script>

</div><!-- form -->
