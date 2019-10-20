<?php
/** @var $this AdminController */

use app\modules\blog\models\Category;
use app\modules\blog\models\Group;
use app\modules\blog\models\Post;
use app\components\AdminController;
use app\modules\user\models\User;

/** @var $model Post */

$this->title = 'Записи блога';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Записи блога',
];

$this->params['admin'] = [
    ['label' => 'Добавить', 'url' => $this->createUrl('create')],
    ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')],
    ['label' => 'Метки', 'url' => $this->createUrl('/blog/admin/tag/index')],
    ['label' => 'Тематические группы', 'url' => $this->createUrl('/blog/admin/group/index')],
];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Записи блога</h1>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(50),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'date',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'name' => 'title',
            'class' => \app\components\widgets\grid\LinkColumn::class,
        ],
        [
            'name' => 'category_id',
            'filter' => Category::model()->getTabList(),
            'value' => static function ($data) {
                return $data->category ? $data->category->fullTitle : '';
            }
        ],
        [
            'name' => 'group_id',
            'header' => 'Группа',
            'filter' => Group::model()->getAssocList(),
            'value' => static function ($data) {
                return $data->group ? $data->group->title : '';
            }
        ],
        [
            'class' => \app\components\widgets\grid\ToggleColumn::class,
            'name' => 'public',
            'header' => 'О',
            'filter' => [1 => 'Опубликовано', 0 => 'Не опубликовано'],
            'titles' => [1 => 'Опубликовано', 0 => 'Не опубликовано'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{view}',
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
