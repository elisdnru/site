<div class="search_form form">
<?php echo CHtml::beginForm(Yii::app()->createUrl('/shop/search'), 'get'); ?>
    <div class="row search_word">
        <?php echo CHtml::activeTextField($form, 'word', array('title'=>'Поиск по каталогу', 'placeholder'=>'Поиск по каталогу')); ?>
    </div>
    <div class="row buttons search_button">
        <?php echo CHtml::submitButton('', array('name'=>'on')); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>
