<?php
/** @var $model \app\modules\comment\models\Comment */

use app\assets\CommentsAsset;

$this->title = 'Комментарий';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Комментарии' => ['index'],
    'Комментарий',
];

$this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['update', 'id' => $model->id]];
$this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['index']];

CommentsAsset::register($this);
?>

<h1>Просмотр комментария</h1>

<?= $this->render('@app/modules/comment/views/admin/comment/_view', ['data' => $model]); ?>
