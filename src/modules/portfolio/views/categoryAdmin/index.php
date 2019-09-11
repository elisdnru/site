<?php
$this->pageTitle = 'Категории портфолио';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['/portfolio/workAdmin/index'],
    'Категории',
];
$this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/workAdmin/index')];
$this->admin[] = ['label' => 'Добавить категорию', 'url' => $this->createUrl('create')];

$this->info = 'Категории работ';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории работ</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
