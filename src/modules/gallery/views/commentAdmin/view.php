<?php
$this->pageTitle = 'Комментарий';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Комментарии' => ['index'],
    'Комментарий',
];

$this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('update', ['id' => $model->id])];
$this->admin[] = ['label' => 'Комментарии', 'url' => $this->createUrl('index')];
$this->info = 'Комментарии';

?>

    <h1>Просмотр комментария</h1>

<?php $this->renderPartial('comment.views.commentAdmin._view', ['data' => $model]); ?>