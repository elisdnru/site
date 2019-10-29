<?php
use app\modules\search\forms\SearchForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $form SearchForm */
?>
<div class="search_form">
    <?= Html::beginForm(Url::to(['/search/default/index']), 'get') ?>
    <div class="search_word">
        <?= Html::textInput('q', $form->q, ['placeholder' => 'Поиск']) ?>
    </div>
    <div class="search_button">
        <button type="submit"></button>
    </div>
    <?= Html::endForm() ?>
</div>
