<div class="search_form form">
<?php DUrlRulesHelper::import('search'); ?>
<?php echo CHtml::beginForm(Yii::app()->createUrl('/search/default/index'), 'get'); ?>
    <div class="row search_word">
        <?php echo CHtml::textField('q', $form->q, array('placeholder'=>'Поиск')); ?>
    </div>
    <div class="row buttons search_button">
        <?php echo CHtml::submitButton('', array('name'=>'')); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>