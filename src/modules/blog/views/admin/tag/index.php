<?php
/** @var $this AdminController */
/** @var $model \app\modules\blog\models\Tag */

use app\components\AdminController;

$this->title = 'Метки записей';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Записи' => ['/blog/admin/post/index'],
    'Метки записей',
];

$this->params['admin'][] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->params['admin'][] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')];
$this->params['admin'][] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/admin/group/index')];
$this->params['admin'][] = ['label' => 'Добавить метку', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Метки записей блога</h1>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'frequency',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
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
