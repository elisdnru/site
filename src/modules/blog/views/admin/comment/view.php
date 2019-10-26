<?php
/** @var $model \app\modules\blog\models\Comment */

use app\assets\CommentsAsset;

$this->title = 'Комментарий';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Комментарии' => ['index'],
    'Комментарий',
];

$this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['update', 'id' => $model->id]];
$this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['index']];

CommentsAsset::register(Yii::$app->view);
?>

<h1>Просмотр комментария</h1>

<?= $this->renderPartial('comment.views.admin.comment._view', ['data' => $model]); ?>
