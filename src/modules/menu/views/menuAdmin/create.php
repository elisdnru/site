<?php
/* @var $this DAdminController */

use app\modules\main\components\DAdminController;
use app\modules\menu\models\Menu;

/* @var $model Menu */

$this->pageTitle = 'Редактор меню';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Меню' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Пункты меню', 'url' => $this->createUrl('index')];
if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Создать страницу', 'url' => $this->createUrl('admin/pages/update')];
}

$this->info = 'Псевдонимы используются системой для вывода соответствующих меню в шаблоне';
?>

<h1>Добавление пункта меню</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

