<?php
/** @var $this \yii\web\View */

use app\modules\blog\models\Tag;

/** @var $model Tag */

$this->title = 'Редактор метки блога';
$this->params['breadcrumbs'] = [
    'Блоги' => ['/blog/admin/post'],
    'Метки' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Метки', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
$this->params['admin'][] = ['label' => 'Группы', 'url' => ['/blog/admin/group/index']];
?>

<h1>Добавление категории блога</h1>

<?= $this->render('_form', ['model' => $model]); ?>
