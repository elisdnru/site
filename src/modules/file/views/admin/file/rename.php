<?php

use app\components\Csrf;
use app\modules\block\models\Block;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $path
 * @var Block $model
 */

$this->title = 'Переименование';
$this->params['breadcrumbs'] = [
    'Файлы' => ['index'],
    $path => ['index', 'path' => $path],
    'Переименование',
];

$this->params['admin'][] = ['label' => 'Файлы', 'url' => ['index']];
?>

<h1>Переименование</h1>

<div class="form">

    <form method="post">

        <?= Csrf::hiddenInput() ?>

        <fieldset>
            <div class="row<?= $model->hasErrors('name') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'name') ?><br />
                <?= Html::activeTextInput($model, 'name', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'name', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

    </form>

</div>

