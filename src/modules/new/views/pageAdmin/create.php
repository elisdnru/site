<?php
$this->pageTitle = 'Редактор новостной страницы';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Новости' => ['index'],
    'Редактор новостной страницы',
];

$this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('index')];
if ($this->moduleAllowed('newsgallery')) {
    if ($model->id) {
        $this->admin[] = ['label' => 'Галереи', 'url' => $this->createUrl('/newsgallery/galleryAdmin/index')];
    }
}

$this->info = 'Выберите из существующих страниц';
?>

<h1>Добавление новостной страницы</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
