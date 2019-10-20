<?php
/** @var $this AdminController */
/** @var $model \app\modules\blog\models\Category */

use app\components\AdminController;

$this->title = 'Категории записей';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Записи' => ['/blog/admin/post/index'],
    'Категории записей',
];

$this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->admin[] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/admin/group/index')];
$this->admin[] = ['label' => 'Добавить категорию', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории блога</h1>

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
            'template' => '{view}',
            'viewButtonUrl' => '$data->url',
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

