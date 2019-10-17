<?php
/** @var $form \app\modules\search\forms\SearchForm */
?>
<div class="search_form">
    <?php echo CHtml::beginForm(Yii::app()->createUrl('/search/default/index'), 'get'); ?>
    <div class="search_word">
        <?php echo CHtml::textField('q', $form->q, ['placeholder' => 'Поиск']); ?>
    </div>
    <div class="search_button">
        <button type="submit"></button>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
