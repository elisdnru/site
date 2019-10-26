<?php
/** @var $form SearchForm */

use app\modules\search\forms\SearchForm;
use yii\helpers\Url;

?>
<div class="search_form">
    <?= CHtml::beginForm(Url::to(['/search/default/index']), 'get') ?>
    <div class="search_word">
        <?= CHtml::textField('q', $form->q, ['placeholder' => 'Поиск']) ?>
    </div>
    <div class="search_button">
        <button type="submit"></button>
    </div>
    <?= CHtml::endForm() ?>
</div>
