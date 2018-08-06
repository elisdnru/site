<?php
$this->pageTitle = 'Новости';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['/page/pageAdmin/index'],
    'Шаблоны' => ['index'],
    $model->title
];

$this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('update', ['id' => $this->id])];
if ($this->moduleAllowed('page')) {
    $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/pageAdmin/index')];
}
$this->admin[] = ['label' => 'Добавить шаблон', 'url' => $this->createUrl('create')];

$this->info = 'Шаблоны';
?>

<?php $this->layout = '//layouts/page/' . $model->alias; ?>

<h1><?php echo CHtml::encode($model->title); ?></h1>
