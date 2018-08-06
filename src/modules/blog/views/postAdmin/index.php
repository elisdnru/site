<?php
/* @var $this DAdminController */
/* @var $model BlogPost */

$this->pageTitle = 'Записи блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи блога',
];

$this->admin = [
    ['label' => 'Добавить', 'url' => $this->createUrl('create')],
    ['label' => 'Категории', 'url' => $this->createUrl('/blog/categoryAdmin/index')],
    ['label' => 'Метки', 'url' => $this->createUrl('/blog/tagAdmin/index')],
    ['label' => 'Тематические группы', 'url' => $this->createUrl('/blog/groupAdmin/index')],
];
$this->info = 'Блоги';
?>

    <p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
    <h1>Записи блога</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>