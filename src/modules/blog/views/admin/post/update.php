<?php
/** @var $this AdminController */

use app\modules\blog\models\Post;
use app\components\AdminController;

/** @var $model Post */

$this->title = 'Редактор записи блога';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Записи блога' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];
$this->params['admin'][] = ['label' => 'Все записи', 'url' => $this->createUrl('index')];
$this->params['admin'][] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')];
$this->params['admin'][] = ['label' => 'Править категорию', 'url' => $this->createUrl('/blog/admin/category/update', ['id' => $model->category_id])];
$this->params['admin'][] = ['label' => 'Метки', 'url' => $this->createUrl('/blog/admin/tag/index')];
?>

<h1>Редактирование записи</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>


