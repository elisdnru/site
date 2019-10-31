<?php
use app\modules\search\forms\SearchForm;
use yii\helpers\Html;

/** @var $form SearchForm */
?>
<div class="search_form">
    <?= Html::beginForm(['/search/default/index'], 'get') ?>
    <div class="search_word">
        <?= Html::textInput('q', $form->q, ['placeholder' => 'Поиск']) ?>
    </div>
    <div class="search_button">
        <button type="submit"></button>
    </div>
    <?= Html::endForm() ?>
</div>
