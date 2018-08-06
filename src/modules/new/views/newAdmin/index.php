<?php
$this->pageTitle = 'Новости';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Новости',
];

if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Новостные страницы', 'url' => $this->createUrl('/new/pageAdmin/index')];
}
if ($this->moduleAllowed('new')) {
    $this->admin[] = ['label' => 'Тематические группы', 'url' => $this->createUrl('/new/groupAdmin/index')];
}
if ($this->moduleAllowed('new')) {
    $this->admin[] = ['label' => 'Добавить новость', 'url' => $this->createUrl('create')];
}

$this->info = 'Чтобы добавлять новости на любую страницу измените её тип на «Список материалов»';
?>

    <p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
    <h1>Новости</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>