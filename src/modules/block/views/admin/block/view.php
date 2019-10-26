<?php
use app\modules\block\models\Block;

/** @var $model Block */

$this->title = 'Блок ' . $model->title;
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоки' => ['index'],
    $model->title,
];

$this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['update', 'id' => $model->id]];
$this->params['admin'][] = ['label' => 'Блоки', 'url' => ['index']];
?>

<h1>Просмотр блока &laquo;<?= CHtml::encode($model->title) ?>&raquo;</h1>

<?= $model->text ?>
