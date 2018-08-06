<?php
$this->pageTitle = 'Редактор материала';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Новости' => ['index'],
    'Редактор',
];

if ($model->url) {
    $this->admin[] = ['label' => 'Просмотр', 'url' => $model->url];
}
$this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('index')];
if ($this->moduleAllowed('newsgallery')) {
    if ($model->id) {
        $this->admin[] = ['label' => 'Галереи', 'url' => $this->createUrl('/newsgallery/galleryAdmin/index')];
    }
}
if ($model->id && $model->page) {
    $this->admin[] = ['label' => 'Просмотр страницы', 'url' => $model->page->url];
}
if ($this->moduleAllowed('page')) {
    if ($model->page_id) {
        $this->admin[] = ['label' => 'Править страницу', 'url' => $this->createUrl('', ['id' => $model->page_id])];
    }
}

$this->info = 'В поле «Раздел» перечислены страницы с типом «Новости/Статьи»';
?>

<h1>Редактирование новости</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
