<?php
/** @var $this \yii\web\View */

use app\modules\blog\models\Category;

/** @var $model Category */

$this->title = 'Редактор категории блога';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоги' => ['/blog/admin/post'],
    'Категории' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Группы', 'url' => ['/blog/admin/group/index']];
?>

<h1>Редактирование категории блога</h1>

<?= $this->render('_form', ['model' => $model]); ?>
