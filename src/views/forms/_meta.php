<?php
use yii\db\ActiveRecord;
use yii\helpers\Html;

/** @var ActiveRecord $model */
?>

<fieldset>
    <h4>Мета-информация</h4>
    <div class="row<?= $model->hasErrors('meta_title') ? ' error' : '' ?>">
        <?= Html::activeLabel($model, 'meta_title') ?><br />
        <?= Html::activeTextInput($model, 'meta_title') ?><br />
        <?= Html::error($model, 'meta_title', ['class' => 'errorMessage']) ?>
    </div>
    <div class="row<?= $model->hasErrors('meta_description') ? ' error' : '' ?>">
        <?= Html::activeLabel($model, 'meta_description') ?><br />
        <?= Html::activeTextarea($model, 'meta_description', ['rows' => 3, 'cols' => 80]) ?><br />
        <?= Html::error($model, 'meta_description', ['class' => 'errorMessage']) ?>
    </div>
</fieldset>
