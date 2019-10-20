<?php
/** @var $model \app\modules\portfolio\models\Category */

$this->title = 'Категории портфолио';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['/portfolio/admin/work/index'],
    'Категории',
];
$this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/admin/work/index')];
$this->admin[] = ['label' => 'Добавить категорию', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории работ</h1>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'sort',
            'htmlOptions' => ['style' => 'width:50px;text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\IndentLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);

