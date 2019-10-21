<?php
/** @var $form SearchForm */

use app\modules\blog\forms\SearchForm;

?>
<div class="search_form form">
    <?php echo CHtml::beginForm(Yii::app()->createUrl('/blog/default/search'), 'get'); ?>
    <div class="row search_word">
        <?php echo CHtml::textField('word', $form->word, ['placeholder' => 'Поиск в блоге']); ?>
    </div>
    <div class="row buttons search_button">
        <button type="submit"></button>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
