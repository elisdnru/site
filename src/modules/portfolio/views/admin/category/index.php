<?php
/** @var $model Category */

use app\components\widgets\grid\ButtonColumn;
use app\components\widgets\grid\IndentLinkColumn;
use app\components\widgets\grid\LinkColumn;
use app\modules\portfolio\models\Category;

$this->title = 'Категории портфолио';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['/portfolio/admin/work/index'],
    'Категории',
];
$this->params['admin'][] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/admin/work/index')];
$this->params['admin'][] = ['label' => 'Добавить категорию', 'url' => $this->createUrl('create')];
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
            'class' => IndentLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => LinkColumn::class,
            'name' => 'alias',
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

