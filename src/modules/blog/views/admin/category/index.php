<?php
/** @var $this AdminController */
/** @var $model Category */

use app\components\AdminController;
use app\components\widgets\grid\ButtonColumn;
use app\components\widgets\grid\IndentLinkColumn;
use app\components\widgets\grid\LinkColumn;
use app\modules\blog\models\Category;

$this->title = 'Категории записей';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Записи' => ['/blog/admin/post/index'],
    'Категории записей',
];

$this->params['admin'][] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->params['admin'][] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/admin/group/index')];
$this->params['admin'][] = ['label' => 'Добавить категорию', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?= $this->createUrl('create') ?>">Добавить</a></p>
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
            'class' => IndentLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => LinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => ButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->url',
        ],
        [
            'class' => ButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);

