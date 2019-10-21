<?php
/** @var $this AdminController */
/** @var $model \app\modules\blog\models\Tag */

use app\components\AdminController;
use app\components\widgets\grid\ButtonColumn;
use app\components\widgets\grid\LinkColumn;

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
            'class' => LinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => LinkColumn::class,
            'name' => 'frequency',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
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
