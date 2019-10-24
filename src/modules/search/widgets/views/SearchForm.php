<?php
/** @var $form SearchForm */

use app\modules\search\forms\SearchForm;

?>
<div class="search_form">
    <?= CHtml::beginForm(Yii::app()->createUrl('/search/default/index'), 'get') ?>
    <div class="search_word">
        <?= CHtml::textField('q', $form->q, ['placeholder' => 'Поиск']) ?>
    </div>
    <div class="search_button">
        <button type="submit"></button>
    </div>
    <?= CHtml::endForm() ?>
</div>
