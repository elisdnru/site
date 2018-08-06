<?php
$this->pageTitle = 'Динамические атрибуты';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Атрибуты',
];

$this->admin[] = ['label' => 'Добавить атрибут', 'url' => $this->createUrl('create')];

$this->info = 'Вы можете переключать значения флага публикации щёлкая непосредственно по нему';
?>

    <p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

    <h1>Динамические атрибуты</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>