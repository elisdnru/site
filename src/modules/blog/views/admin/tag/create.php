<?php
/** @var $this AdminController */

use app\modules\blog\models\Tag;
use app\components\AdminController;

/** @var $model Tag */

$this->title = 'Редактор метки блога';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоги' => ['/blog/admin/post'],
    'Метки' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Метки', 'url' => $this->createUrl('index')];
$this->params['admin'][] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->params['admin'][] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')];
$this->params['admin'][] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/admin/group/index')];
?>

<h1>Добавление категории блога</h1>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
