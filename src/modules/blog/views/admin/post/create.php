<?php
/** @var $this AdminController */

use app\modules\blog\models\Post;
use app\components\AdminController;

/** @var $model Post */

$this->title = 'Редактор записи блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи блога' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Все записи', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')];
$this->admin[] = ['label' => 'Метки', 'url' => $this->createUrl('/blog/admin/tag/index')];

?>

<h1>Добавление записи</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>


