<?php
/* @var $this AdminController */

use app\modules\blog\models\Category;
use app\components\AdminController;

/* @var $model Category */

$this->pageTitle = 'Редактор категории блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Блоги' => ['/blog/postAdmin'],
    'Категории' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin/index')];
$this->admin[] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/groupAdmin/index')];
?>

<h1>Добавление категории блога</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
