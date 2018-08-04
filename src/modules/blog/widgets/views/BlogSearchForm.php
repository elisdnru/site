<div class="search_form form">
<?php echo CHtml::beginForm(Yii::app()->createUrl('/blog/default/search'), 'get'); ?>
    <div class="row search_word">
        <?php echo CHtml::textField('word', $form->word, array('class'=>'graytext', 'placeholder'=>'Поиск в блоге')); ?>
    </div>
    <div class="row buttons search_button">
        <?php echo CHtml::submitButton('', array('name'=>'')); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>
