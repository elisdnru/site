<?php

use app\modules\blog\models\Category;
use yii\web\View;

/**
 * @var View $this
 * @var Category $model
 */

$this->title = 'Редактор категории блога';
$this->params['breadcrumbs'] = [
    'Блоги' => ['/blog/admin/post'],
    'Категории' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Группы', 'url' => ['/blog/admin/group/index']];
?>

<h1>Редактирование категории блога</h1>

<?= $this->render('_form', ['model' => $model]) ?>
