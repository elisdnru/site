<?php
/** @var $this \yii\web\View */
/** @var $model Tag */

use app\modules\blog\models\Tag as Tag;
use app\widgets\grid\ButtonColumn;
use app\widgets\grid\LinkColumn;
use yii\helpers\Url;

$this->title = 'Метки записей';
$this->params['breadcrumbs'] = [
    'Записи' => ['/blog/admin/post/index'],
    'Метки записей',
];

$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
$this->params['admin'][] = ['label' => 'Группы', 'url' => ['/blog/admin/group/index']];
$this->params['admin'][] = ['label' => 'Добавить метку', 'url' => ['create']];
?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>
<h1>Метки записей блога</h1>

<?php Yii::app()->controller->widget('zii.widgets.grid.CGridView', [
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
            'viewButtonUrl' => static function (Tag $data) {
                return $data->getUrl();
            },
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
