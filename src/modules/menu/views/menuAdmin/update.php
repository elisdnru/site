<?php
/* @var $this AdminController */

use app\modules\main\components\AdminController;
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
    $this->admin[] = ['label' => 'Создать страницу', 'url' => $this->createUrl('/page/pageAdmin/create')];
}

$this->info = 'Псевдонимы используются системой для вывода соответствующих меню в шаблоне';
?>

<h1>Редактирование пункта меню</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

