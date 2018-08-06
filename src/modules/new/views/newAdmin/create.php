<?php
$this->pageTitle = 'Редактор материала';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Новости' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('index')];
if ($this->moduleAllowed('newsgallery')) {
    if ($model->id) {
        $this->admin[] = ['label' => 'Галереи', 'url' => $this->createUrl('/newsgallery/galleryAdmin/index')];
    }
}

$this->info = 'В поле «Раздел» перечислены страницы с типом «Новости/Статьи»';
?>

<h1>Добавление новости</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
