<?php
$this->pageTitle = 'Редактор шаблона';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['/page/pageAdmin/index'],
    'Шаблоны' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];
$this->admin[] = ['label' => 'Шаблоны', 'url' => $this->createUrl('index')];
if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/pageAdmin/index')];
}

$this->info = 'После создания страницы Вы можете привязать её к любому пункту меню';

?>

<h1>Редактирование шаблона</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

