<?php
$this->pageTitle = 'Новости';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['/page/pageAdmin/index'],
    'Шаблоны',
];

if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/pageAdmin/index')];
}
$this->admin[] = ['label' => 'Добавить шаблон', 'url' => $this->createUrl('create')];

$this->info = 'Шаблоны';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Шаблоны</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
