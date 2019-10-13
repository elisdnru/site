<?php
$this->pageTitle = 'Комментарий';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Комментарии' => ['index'],
    'Комментарий',
];

$this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('update', ['id' => $model->id])];
$this->admin[] = ['label' => 'Комментарии', 'url' => $this->createUrl('index')];

Yii::app()->clientScript->registerPackage('comments');
?>

<h1>Просмотр комментария</h1>

<?php $this->renderPartial('comment.views.admin.comment._view', ['data' => $model]); ?>
