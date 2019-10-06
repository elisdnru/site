<?php
$this->pageTitle = 'Редактор страниц';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['/page/pageAdmin/index'],
    'Шаблоны' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Шаблоны', 'url' => $this->createUrl('index')];
if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/new/pageAdmin/index')];
}
?>

<h1>Добавление шаблона</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

