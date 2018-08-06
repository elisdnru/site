<?php
$this->pageTitle = 'Редактор новостной страницы';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Новости' => ['/new/newAdmin/index'],
    'Новостные страницы' => ['index'],
    'Редактор',
];

if ($model->id && $model->page) {
    $this->admin[] = ['label' => 'Просмотр', 'url' => $model->page->url];
}
$this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('index')];

$this->info = 'Редактирование шаблона';
?>

<h1>Редактирование новостной страницы</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
