<?php
use app\modules\blog\forms\SearchForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var SearchForm $form */
?>
<div class="search_form form">
    <?= Html::beginForm(Url::to(['/blog/default/search']), 'get') ?>
    <div class="row search_word">
        <?= Html::textInput('word', $form->word, ['placeholder' => 'Поиск в блоге']) ?>
    </div>
    <div class="row buttons search_button">
        <button type="submit"></button>
    </div>
    <?= Html::endForm() ?>
</div>
