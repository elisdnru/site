<?php
/** @var $model \app\modules\blog\models\Comment */

$this->pageTitle = 'Редактор комментариев';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Комментарии' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Комментарии', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];
?>

<h1>Редактирование комментария</h1>

<?php $this->renderPartial('comment.views.admin.comment.._form', ['model' => $model]); ?>
