<?php
/* @var $this AdminController */

use app\modules\blog\models\BlogPost;
use app\modules\main\components\AdminController;

/* @var $model BlogPost */

$this->pageTitle = 'Редактор записи блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи блога' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Все записи', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/categoryAdmin/index')];
$this->admin[] = ['label' => 'Метки', 'url' => $this->createUrl('/blog/tagAdmin/index')];

?>

<h1>Добавление записи</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>


