<?php
/* @var $this DAdminController */

use app\modules\main\components\DAdminController;

$this->pageTitle = 'Метки записей';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи' => ['/blog/postAdmin/index'],
    'Метки записей',
];

$this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin/index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/categoryAdmin/index')];
$this->admin[] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/groupAdmin/index')];
$this->admin[] = ['label' => 'Добавить метку', 'url' => $this->createUrl('create')];

$this->info = 'Метки записей';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Метки записей блога</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
