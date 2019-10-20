<?php
/** @var $this AdminController */

use app\modules\blog\models\Category;
use app\components\AdminController;

/** @var $model Category */

$this->title = 'Редактор категории блога';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоги' => ['/blog/admin/post'],
    'Категории' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Категории', 'url' => $this->createUrl('index')];
$this->params['admin'][] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->params['admin'][] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/admin/group/index')];
?>

<h1>Редактирование категории блога</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
