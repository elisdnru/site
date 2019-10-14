<?php
/** @var $model \app\modules\portfolio\models\Category */

$this->pageTitle = 'Категории портфолио';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['/portfolio/admin/work/index'],
    'Категории',
];
$this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/admin/work/index')];
$this->admin[] = ['label' => 'Добавить категорию', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории работ</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
