<?php
$this->pageTitle = 'Редактор страниц';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Cтраницы', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Просмотр', 'url' => $model->url];
if ($this->moduleAllowed('menu')) {
    $this->admin[] = ['label' => 'Пункты меню', 'url' => $this->createUrl('/menu/admin/menu/index')];
}
?>

<h1>Редактирование страницы</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
