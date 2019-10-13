<?php
/* @var $this AdminController */

use app\modules\blog\models\Tag;
use app\components\AdminController;

/* @var $model Tag */

$this->pageTitle = 'Редактор метки блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Блоги' => ['/blog/postAdmin'],
    'Метки' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Метки', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')];
$this->admin[] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/admin/group/index')];
?>

<h1>Редактирование метки блога</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
