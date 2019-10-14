<?php
/** @var $model \app\modules\page\models\Page */
$this->pageTitle = 'Страницы';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы',
];

if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Добавить страницу', 'url' => $this->createUrl('create')];
}
if ($this->moduleAllowed('menu')) {
    $this->admin[] = ['label' => 'Пункты меню', 'url' => $this->createUrl('/menu/admin/menu/index')];
}
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Страницы</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
