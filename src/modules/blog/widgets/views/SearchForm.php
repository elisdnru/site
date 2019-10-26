<?php
/** @var $form SearchForm */

use app\modules\blog\forms\SearchForm;
use yii\helpers\Url;

?>
<div class="search_form form">
    <?= CHtml::beginForm(Url::to(['/blog/default/search']), 'get') ?>
    <div class="row search_word">
        <?= CHtml::textField('word', $form->word, ['placeholder' => 'Поиск в блоге']) ?>
    </div>
    <div class="row buttons search_button">
        <button type="submit"></button>
    </div>
    <?= CHtml::endForm() ?>
</div>
