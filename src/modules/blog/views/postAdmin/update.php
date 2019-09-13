<?php
/* @var $this DAdminController */

use app\modules\main\components\DAdminController;

/* @var $model BlogPost */

$this->pageTitle = 'Редактор записи блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи блога' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];
$this->admin[] = ['label' => 'Все записи', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/categoryAdmin/index')];
$this->admin[] = ['label' => 'Править категорию', 'url' => $this->createUrl('/blog/categoryAdmin/update', ['id' => $model->category_id])];
$this->admin[] = ['label' => 'Метки', 'url' => $this->createUrl('/blog/tagAdmin/index')];
?>

<h1>Редактирование записи</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>


