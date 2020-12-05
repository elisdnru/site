<?php
use yii\db\ActiveRecord;
use yii\helpers\Html;

/** @var ActiveRecord $model */
?>

<fieldset>
    <h4>Мета-информация</h4>
    <div class="row<?= $model->hasErrors('pagetitle') ? ' error' : '' ?>">
        <?= Html::activeLabel($model, 'pagetitle') ?><br />
        <?= Html::activeTextInput($model, 'pagetitle') ?><br />
        <?= Html::error($model, 'pagetitle', ['class' => 'errorMessage']) ?>
    </div>
    <div class="row<?= $model->hasErrors('description') ? ' error' : '' ?>">
        <?= Html::activeLabel($model, 'description') ?><br />
        <?= Html::activeTextarea($model, 'description', ['rows' => 3, 'cols' => 80]) ?><br />
        <?= Html::error($model, 'description', ['class' => 'errorMessage']) ?>
    </div>
</fieldset>
