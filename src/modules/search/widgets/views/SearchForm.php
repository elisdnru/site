<?php

use app\modules\search\forms\SearchForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var SearchForm $form */
?>
<div class="search_form">
    <form action="<?= Url::to(['/search/default/index']) ?>" method="get">
        <div class="search_word">
            <input type="text" name="q" value="<?= Html::encode($form->q) ?>" placeholder="Поиск">
        </div>
        <div class="search_button">
            <button type="submit"></button>
        </div>
    </form>
</div>
