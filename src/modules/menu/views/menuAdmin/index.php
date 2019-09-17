<?php
/* @var $this AdminController */

use app\modules\main\components\AdminController;
use app\modules\menu\models\Menu;

/* @var $items Menu[] */

$this->pageTitle = 'Меню';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Меню',
];

if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/pageAdmin/index')];
}
$this->admin[] = ['label' => 'Добавить пункт', 'url' => $this->createUrl('create')];

$this->info = 'Используйте псевдонимы, чтобы выводить нужные меню на страницу с помощью команды [*menu|parent=&lt;alias&gt;*]';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Пункты меню</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
