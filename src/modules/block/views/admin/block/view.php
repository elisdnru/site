<?php
/** @var $model \app\modules\block\models\Block */

$this->title = 'Блок ' . $model->title;
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоки' => ['index'],
    $model->title,
];

$this->params['admin'][] = ['label' => 'Редактировать', 'url' => $this->createUrl('update', ['id' => $model->id])];
$this->params['admin'][] = ['label' => 'Блоки', 'url' => $this->createUrl('index')];
?>

<h1>Просмотр блока &laquo;<?php echo CHtml::encode($model->title); ?>&raquo;</h1>

<?php echo $model->text; ?>
