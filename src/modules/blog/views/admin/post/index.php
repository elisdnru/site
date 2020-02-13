<?php
/** @var $this \yii\web\View */

use app\widgets\grid\ButtonColumn;
use app\widgets\grid\LinkColumn;
use app\widgets\grid\ToggleColumn;
use app\modules\blog\models\Category;
use app\modules\blog\models\Group;
use app\modules\blog\models\Post;
use yii\helpers\Url;

/** @var $model Post */

$this->title = 'Записи блога';
$this->params['breadcrumbs'] = [
    'Записи блога',
];

$this->params['admin'] = [
    ['label' => 'Добавить', 'url' => ['create']],
    ['label' => 'Категории', 'url' => ['/blog/admin/category/index']],
    ['label' => 'Метки', 'url' => ['/blog/admin/tag/index']],
    ['label' => 'Тематические группы', 'url' => ['/blog/admin/group/index']],
];
?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>
<h1>Записи блога</h1>

<?php Yii::app()->controller->widget('zii.widgets.grid.CGridView', [
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
            'class' => LinkColumn::class,
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
            'filter' => Group::find()->getAssocList(),
            'value' => static function ($data) {
                return $data->group ? $data->group->title : '';
            }
        ],
        [
            'class' => ToggleColumn::class,
            'name' => 'public',
            'header' => 'О',
            'filter' => [1 => 'Опубликовано', 0 => 'Не опубликовано'],
            'titles' => [1 => 'Опубликовано', 0 => 'Не опубликовано'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => ButtonColumn::class,
            'template' => '{view}',
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
