<?php
$this->pageTitle = 'Редактор страниц';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Cтраницы', 'url' => $this->createUrl('index')];
if ($this->moduleAllowed('menu')) {
    $this->admin[] = ['label' => 'Пункты меню', 'url' => $this->createUrl('/menu/menuAdmin/index')];
}

$this->info = 'После создания страницы Вы можете привязать её к любому пункту меню';

?>

<h1>Добавление страницы</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

