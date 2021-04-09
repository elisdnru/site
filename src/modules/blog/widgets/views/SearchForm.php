<?php

use app\modules\blog\forms\SearchForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var SearchForm $form */
?>
<div class="search-form form">
    <?= Html::beginForm(Url::to(['/blog/default/search']), 'get') ?>
    <div class="row search-word">
        <?= Html::textInput('q', $form->q, ['placeholder' => 'Поиск в блоге']) ?>
    </div>
    <div class="row buttons search-button">
        <button type="submit"></button>
    </div>
    <?= Html::endForm() ?>
</div>
