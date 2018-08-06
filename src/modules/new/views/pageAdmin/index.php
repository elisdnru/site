<?php
$this->pageTitle = 'Новостные страницы';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Новости' => ['/new/newAdmin/index'],
    'Новостные страницы',
];

if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('/new/newAdmin/index')];
}
if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/pageAdmin/index')];
}
if ($this->moduleAllowed('new')) {
    $this->admin[] = ['label' => 'Тематические группы', 'url' => $this->createUrl('/new/groupAdmin/index')];
}
if ($this->moduleAllowed('new')) {
    $this->admin[] = ['label' => 'Добавить новостную страницу', 'url' => $this->createUrl('create')];
}

$this->info = 'Чтобы добавлять новости на любую страницу добавьте её в этот список';
?>

    <p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
    <h1>Новостные страницы</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>