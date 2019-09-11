<?php
$this->pageTitle = 'Страницы';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы',
];

if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Добавить страницу', 'url' => $this->createUrl('create')];
}
if ($this->moduleAllowed('menu')) {
    $this->admin[] = ['label' => 'Пункты меню', 'url' => $this->createUrl('/menu/menuAdmin/index')];
}
if ($this->moduleAllowed('new')) {
    $this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('/new/newAdmin/index')];
}

$this->info = 'После создания страницы Вы можете привязать её к любому пункту меню';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Страницы</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
