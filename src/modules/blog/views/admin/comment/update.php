<?php
/** @var $model \app\modules\blog\models\Comment */

$this->title = 'Редактор комментариев';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Комментарии' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $model->id]];
?>

<h1>Редактирование комментария</h1>

<?= $this->renderPartial('comment.views.admin.comment.._form', ['model' => $model]); ?>
