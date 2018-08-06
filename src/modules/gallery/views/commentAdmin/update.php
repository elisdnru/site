<?php
$this->pageTitle = 'Редактор комментариев';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Комментарии' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Комментарии', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];

$this->info = 'Комментарии';

?>

<h1>Редактирование комментария</h1>

<?php $this->renderPartial('comment.views.commentAdmin._form', ['model' => $model]); ?>
