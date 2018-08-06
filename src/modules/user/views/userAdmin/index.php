<?php
$this->pageTitle = 'Пользователи';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Пользователи',
];

$this->admin[] = ['label' => 'Добавить пользователя', 'url' => $this->createUrl('create')];

$this->info = 'Пользователи';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Пользователи</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
