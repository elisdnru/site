<?php
/** @var $model \app\modules\comment\models\Comment */

use app\assets\CommentsAsset;

$this->title = 'Комментарий';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Комментарии' => ['index'],
    'Комментарий',
];

$this->params['admin'][] = ['label' => 'Редактировать', 'url' => $this->createUrl('update', ['id' => $model->id])];
$this->params['admin'][] = ['label' => 'Комментарии', 'url' => $this->createUrl('index')];

CommentsAsset::register(Yii::$app->view);
?>

<h1>Просмотр комментария</h1>

<?php $this->renderPartial('comment.views.admin.comment._view', ['data' => $model]); ?>
