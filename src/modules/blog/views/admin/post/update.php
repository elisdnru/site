<?php

use app\modules\blog\models\Post;
use yii\web\View;

/**
 * @var View $this
 * @var Post $model
 */

$this->title = 'Редактор записи блога';
$this->params['breadcrumbs'] = [
    'Записи блога' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $model->id]];
$this->params['admin'][] = ['label' => 'Все записи', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
$this->params['admin'][] = ['label' => 'Править категорию', 'url' => ['/blog/admin/category/update', 'id' => $model->category_id]];
$this->params['admin'][] = ['label' => 'Метки', 'url' => ['/blog/admin/tag/index']];
?>

<h1>Редактирование записи</h1>

<?= $this->render('_form', ['model' => $model]) ?>


