<?php

use app\modules\block\models\Block;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Block $model
 */

$this->title = 'Блок ' . $model->title;
$this->params['breadcrumbs'] = [
    'Блоки' => ['index'],
    $model->title,
];

$this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['update', 'id' => $model->id]];
$this->params['admin'][] = ['label' => 'Блоки', 'url' => ['index']];
?>

<h1>Просмотр блока &laquo;<?= Html::encode($model->title) ?>&raquo;</h1>

<?= $model->text ?>
